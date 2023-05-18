<?php

namespace Bl\LaravelUploadable\Traits;

trait MergeFileRulesTrait
{
    protected $rules = [];

    public function whenFileFilled($fileRules = [])
    {
        foreach($fileRules as $key => $value) {

            if($this->hasFile($key)) {
                $this->rules = array_merge($this->rules, [$key => $value]);
            }

        }

        return $this->rules;
    }
}
