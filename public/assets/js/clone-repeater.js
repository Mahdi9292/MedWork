jQuery.fn.extend({

    createCloneRepeater: function (options = {}) {
        let hasOption = function (optionKey) {
            return options.hasOwnProperty(optionKey);
        };

        let option = function (optionKey) {
            return options[optionKey];
        };

        let generateId = function (string, index=false) {
            return string
                .replace(/\[/g, '_')
                .replace(/\]/g, '')
                .toLowerCase().concat((index !==false ? index.toString() : ''));
        };

        let addItem = function (items, key, fresh = true) {
            let itemContent = items;
            let group = itemContent.data("group");
            let item = itemContent;
            let input = item.find('input,select,textarea');

            input.each(function (index, el) {
                let attrName = $(el).data('name');
                let skipName = $(el).data('skip-name');
                if (skipName != true) {
                    if (typeof attrName === "undefined") {
                        $(el).attr("name", group + "[]");
                    }else {
                        $(el).attr("name", group + "[" + key + "]" + "[" + attrName + "]");
                    }
                } else {
                    if (attrName != 'undefined') {
                        $(el).attr("name", attrName);
                    }
                }
                if (fresh === true || !$(el).val()) {
                    $(el).attr('value', '');
                }

                $(el).attr('id', generateId($(el).attr('name'), (typeof attrName === "undefined" ? key: false)));
                $(el).parent().find('label').attr('for', generateId($(el).attr('name')));
            })

            let itemClone = items;

            /* Handling remove btn */
            let removeButton = itemClone.find('.remove-btn');

            if (key == 0) {
                removeButton.attr('disabled', true);

            } else {
                removeButton.attr('disabled', false);
            }

            removeButton.attr('onclick', '$(this).parents(\'.items\').remove()');

            // ***************************** BS5 Accordion *******************
            // accordion heading
            let accordionClass = '';
            let accordionHeader = itemClone.children().find('.accordion-header');
            if(accordionHeader) {
                accordionHeader.attr('id', 'panel-heading_acc_' + key);
                accordionClass = 'accordion mt-3'
                itemClone.children().find('span.repeaterClass').html((key+1)+'. ');
            }

            // accordion button
            let accordionButton = itemClone.children().find('.accordion-button');
            if(accordionButton) {
                accordionButton.attr('data-bs-target', '#panel-collapse_acc_' + key);
                accordionButton.attr('aria-controls', 'panel-collapse_acc_' + key);
            }

            // accordion heading
            let accordionCollapse = itemClone.children().find('.accordion-collapse');
            if(accordionCollapse) {
                accordionCollapse.attr('id', 'panel-collapse_acc_' + key);
            }
            // ***************************** End BS5 Accordion *******************

            let newItem = $("<div class='items "+accordionClass+"'>" + itemClone.html() + "<div/>");
            newItem.attr('data-index', key)

            newItem.appendTo(repeater);
        };

        /* find elements */
        let repeater = this;
        let items = repeater.find(".items");
        let key = 0;
        let addButton = repeater.find('.repeater-add-btn');

        items.each(function (index, item) {
            items.remove();
            if (hasOption('showFirstItemToDefault') && option('showFirstItemToDefault') == true) {
                addItem($(item), key, false);
                key++;
            } else {
                if (items.length > 1) {
                    addItem($(item), key, false);
                    key++;
                }
            }
        });

        /* handle click and add items */
        addButton.on("click", function () {

            // get last existing item values
            let lastItem = repeater.find('.items').last();
            let lastInputs = lastItem.find('input,select,textarea');

            // add new item
            addItem($(items[0]), key);

            // get newly created item
            let newItem = repeater.find('.items').last();
            let newInputs = newItem.find('input,select,textarea');

            // copy values
            // newInputs.each(function(index, el){
            //     let value = $(lastInputs[index]).val();
            //     $(el).val(value);
            // });

            newInputs.each(function(index, el){

                let attrName = $(el).data('name');

                // Skip copying ID
                if (attrName === 'id') {
                    $(el).val('');
                    return;
                }

                let value = $(lastInputs[index]).val();
                $(el).val(value);
            });

            key++;
        });
    }
});
