jQuery.fn.extend({
    // Renamed to avoid conflict with the standard repeater
    createCloneRepeater: function (options = {}) {
        let hasOption = (key) => options.hasOwnProperty(key);
        let option = (key) => options[key];

        let generateId = function (string, index = false) {
            return string
                .replace(/\[/g, '_')
                .replace(/\]/g, '')
                .toLowerCase().concat((index !== false ? index.toString() : ''));
        };

        let addItem = function (sourceItem, key, fresh = true) {
            let group = sourceItem.data("group");
            let inputs = sourceItem.find('input, select, textarea');

            // Clone the DOM element
            let itemClone = sourceItem.clone();


            sourceItem.find('input, select, textarea').each(function (index, el) {
                let val = $(el).val();
                let name = $(el).attr('name');
                let attrName = $(el).data('name');

                // Find the corresponding input in the CLONE to set value and name
                let targetInput = itemClone.find('input, select, textarea').eq(index);

                if (typeof attrName === "undefined") {
                    targetInput.attr("name", group + "[]");
                } else {
                    targetInput.attr("name", group + "[" + key + "]" + "[" + attrName + "]");
                }

                // Set the ID and Value
                let newId = generateId(targetInput.attr('name'), (typeof attrName === "undefined" ? key : false));
                targetInput.attr('id', newId);
                targetInput.val(val); // This carries the value over

                // Update label association
                itemClone.find('label[for="' + $(el).attr('id') + '"]').attr('for', newId);
            });

            // Update names and IDs in the clone
            itemClone.find('input, select, textarea').each(function (index, el) {
                let attrName = $(el).data('name');
                let skipName = $(el).data('skip-name');

                if (skipName !== true) {
                    if (typeof attrName === "undefined") {
                        $(el).attr("name", group + "[]");
                    } else {
                        $(el).attr("name", group + "[" + key + "]" + "[" + attrName + "]");
                    }
                }

                $(el).attr('id', generateId($(el).attr('name'), (typeof attrName === "undefined" ? key : false)));
                $(el).parent().find('label').attr('for', $(el).attr('id'));

                // IMPORTANT: Transfer the current value from the source to the clone
                // .clone() doesn't always keep the dynamically changed value of selects/textareas
                let sourceValue = inputs.eq(index).val();
                $(el).val(sourceValue);
            });

            // Handling remove btn
            let removeButton = itemClone.find('.remove-btn');
            removeButton.attr('disabled', key === 0);
            removeButton.attr('onclick', '$(this).parents(\'.items\').remove()');

            // Wrap in the standard item container
            let newItem = $("<div class='items'></div>").append(itemClone.html());

            // Re-apply values to the new HTML string object
            itemClone.find('input, select, textarea').each(function(index, el){
                newItem.find('input, select, textarea').eq(index).val($(el).val());
            });

            newItem.attr('data-index', key);
            newItem.appendTo(repeater);
        };

        let repeater = this;
        let initialItems = repeater.find(".items");
        let key = 0;
        let addButton = repeater.find('.repeater-add-btn');

        // Initialize existing items
        initialItems.each(function (index, item) {
            // We don't remove() here like the original to preserve initial server-side values
            key++;
        });

        /* handle click and add items */
        addButton.on("click", function () {
            // Find the LAST item to clone its current values
            let lastItem = repeater.find('.items').last();
            addItem(lastItem, key);
            key++;
        });
    }
});
