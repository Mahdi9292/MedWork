<?php

namespace App\Models;

use App\Traits\HasValidationTrait;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasValidationTrait;

    /**
     * Rules used to validate data in insert, update, and save methods.
     * The array must match the format of data passed to the Validation
     * library.
     *
     * @var array|string
     */
    protected array $validationRules = [];

    /**
     * Contains any custom error messages to be
     * used during data validation.
     *
     * @var array
     */
    protected array $validationMessages = [];

    public $timestamps = false;

    protected function swapAttributes($firstAttribute, $secondAttribute): void
    {
        $temp = $this->$firstAttribute;
        $this->$firstAttribute = $this->$secondAttribute;
        $this->$secondAttribute = $temp;
    }
}
