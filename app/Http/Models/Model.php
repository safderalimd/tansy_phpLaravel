<?php

namespace App\Http\Models;

use App\Exceptions\DbModelNotFoundException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Session;
use Illuminate\Support\Str;

class Model
{
    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'user_id',
        'session_id',
        'debug_sproc',
        'audit_screen_visit',
        'default_facility_id',
        'remember_token',
    ];

    /**
     * The attributes that are values from selectboxes.
     * If the value is not numeric, convert it to a string.
     *
     * @var array
     */
    protected $selects = [];

    /**
     * Is this a new model record.
     *
     * @var boolean
     */
    public $isNewRecord = true;

    /**
     * The model's repository.
     *
     * @var namespace App\Http\Repositories\Repository
     */
    public $repository;

    /**
     * Contains the errors.
     *
     * @var string
     */
    public $errors;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);

        $this->setAttribute('default_facility_id', Session::get('user.defaultFacilityId'));
        $this->setAttribute('user_id', Session::get('user.userID'));
        $this->setAttribute('session_id', Session::get('user.sessionID'));
        $this->setAttribute('debug_sproc', Session::get('user.debugSproc'));
        $this->setAttribute('audit_screen_visit', Session::get('user.auditScreenVisit'));
        $this->setAttribute('screen_id', $this->getScreenId());

        if (isset($this->repositoryNamespace) && !is_null($this->repositoryNamespace)) {
            $class = $this->repositoryNamespace;
            $this->repository = new $class();
        }
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function fill($attributes)
    {
        foreach ($attributes as $key => $value) {
            if (! $this->isGuarded($key)) {
                $this->setAttribute($key, $value);
            } else {
                throw new MassAssignmentException($key);
            }
        }

        return $this;
    }

    /**
     * Determine if the given attribute may not be mass assigned.
     *
     * @param  string  $key
     * @return bool
     */
    public function isGuarded($key)
    {
        return in_array($key, $this->guarded);
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if ($this->hasSetMutator($key)) {
            $method = 'set'.Str::studly($key).'Attribute';
            $value = $this->{$method}($value);
        }

        $this->attributes[$key] = $value;
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
    }

    /**
     * Determine if a set mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasSetMutator($key)
    {
        return method_exists($this, 'set'.Str::studly($key).'Attribute');
    }

    /**
     * Determine if an attribute exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        unset($this->attributes[$key]);
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Call a method on the repository
     */
    public function __call($method, $parameters)
    {
        $method = 'get' . ucfirst($method);
        return call_user_func_array([$this->repository, $method], $parameters);
    }

    /**
     * Return the errors.
     *
     * @return string
     */
    public function getErrors()
    {
        // flash data to the session to populate forms
        Session::flashInput($this->attributes);
        return $this->errors;
    }

    public function save($attributes = null)
    {
        return $this->insert($attributes);
    }

    public function insert($attributes = null)
    {
        if (!is_null($attributes)) {
            $this->fill($attributes);
        }

        return $this->repository->insert($this);
    }

    public function update($attributes = null)
    {
        if (!is_null($attributes)) {
            $this->fill($attributes);
        }

        return $this->repository->update($this);
    }

    public function delete()
    {
        return $this->repository->delete($this);
    }

    public function isNewRecord()
    {
        return $this->isNewRecord;
    }

    public static function find($id)
    {
        $instance = new static;

        // select the data from the database
        $data = $instance->repository->detail($instance, $id);
        $data = first_resultset($data);
        $data = isset($data[0]) ? (array)$data[0] : [];

        // save only non numeric keys
        $attributes = [];
        foreach ($data as $key => $value) {
            if (!is_numeric($key)) {
                $attributes[$key] = $value;
            }
        }

        // throw exception if the model is not found
        if (empty($attributes)) {
            throw new DbModelNotFoundException('There is no record with this id.');
        }

        // set attributes to the model instance
        $instance->fill($attributes);

        // flash data to the session to populate edit forms
        Session::flashInput($instance->getAttributes());

        // mark this model as not a new record
        $instance->isNewRecord = false;

        return $instance;
    }

    public static function findOrFail($id)
    {
        $instance = new static;

        // select the data from the database
        $data = $instance->repository->getModelById($id);

        // throw exception if the model is not found
        if (empty($data)) {
            throw new DbModelNotFoundException('Not found model with this id.');
        }

        // set attributes to the model instance
        $attributes = (array)$data[0];
        $instance->fill($attributes);

        // flash data to the session to populate edit forms
        Session::flashInput($instance->getAttributes());

        // mark this model as not a new record
        $instance->isNewRecord = false;

        return $instance;
    }

    public function setProcedureOparams($oparams)
    {
        foreach ($oparams as $key => $value) {
            $name = substr($key, 8);
            $this->attributes[$name] = $value;
        }
    }

    public function attributesCount()
    {
        return count($this->attributes);
    }

    public function getScreenId()
    {
        return screen_id($this->getScreenIdProperty());
    }

    public function getScreenIdProperty()
    {
        return $this->screenId;
    }

    public static function screenId()
    {
        $instance = new static;
        $screenId = $instance->getScreenIdProperty();
        return screen_id($screenId);
    }

    public static function staticScreenId()
    {
        return screen_id(static::$staticScreenId);
    }

    public function isSelectNoneOption($param)
    {
        if (!in_array($param, $this->selects)) {
            return false;
        }

        if ($this->{$param} == 'none') {
            return true;
        }

        return false;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}
