<?php

/**
 * Bicubic PHP Framework
 *
 * @author     Juan Rodríguez-Covili <juan@bicubic.cl>
 * @copyright  2011 Bicubic Technology - http://www.bicubic.cl
 * @license    MIT
 * @framework  2.2
 */
class Navigation {

    public $application;

    function __construct(Application $application) {
        $this->application = $application;
    }

    public function lang($string, $langstr = null) {
        return $this->application->lang($string, $langstr);
    }

    public function config($string) {
        return $this->application->config($string);
    }

    public function item($array, $key, $default = null, $langstr = null) {
        return $this->application->item($array, $key, $default, $langstr);
    }

    public function error($message) {
        return $this->application->error($message);
    }

    public function message($message) {
        return $this->application->message($message);
    }

    public function photoUrl($baseUrl) {
        return $this->application->photoUrl($baseUrl);
    }

    public function compareLangStrings($a, $b) {
        return strcasecmp($this->lang($a), $this->lang($b));
    }

    public function compareObjectsByLangName($a, $b) {
        return strcasecmp($a->getName(), $b->getName());
    }

    public function compareObjectsByComparer($a, $b) {
        if ($a->comparer < $b->comparer) {
            return -1;
        }
        if ($a->comparer == $b->comparer) {
            return 0;
        }
        if ($a->comparer > $b->comparer) {
            return 1;
        }
    }

    public function compareObjectsByTimeBack($a, $b) {
        if ($a->time > $b->time) {
            return -1;
        }
        if ($a->time == $b->time) {
            return 0;
        }
        if ($a->time < $b->time) {
            return 1;
        }
    }

    public function compareObjectsByComparerAndName($a, $b) {
        if ($a->comparer < $b->comparer) {
            return -1;
        }
        if ($a->comparer == $b->comparer) {
            return strcasecmp($a->getName(), $b->getName());
        }
        if ($a->comparer > $b->comparer) {
            return 1;
        }
    }

    public function compareObjectsByName($a, $b) {
        return strcasecmp($this->lang($a->getName()), $this->lang($b->getName()));
    }

    public function compareObjectsByDistance($a, $b) {
        if ($a->getDistance() < $b->getDistance()) {
            return -1;
        }
        if ($a->getDistance() == $b->getDistance()) {
            return 0;
        }
        if ($a->getDistance() > $b->getDistance()) {
            return 1;
        }
    }

    public function compareJsonObjectsByDistance($a, $b) {
        if ($a->distance < $b->distance) {
            return -1;
        }
        if ($a->distance == $b->distance) {
            return 0;
        }
        if ($a->distance > $b->distance) {
            return 1;
        }
    }

    public function normalize($string) {
        return ucwords(strtolower(trim($string)));
    }

    public function objectFormElement(DataObject $object, $property) {
        $objectName = get_class($object);
        $getter = "get" . strtoupper(substr($property["name"], 0, 1)) . substr($property["name"], 1);
        $value = $object->$getter();
        if ($this->item($property, "private", false)) {
            return "";
        } else if ($this->item($property, "hidden", false)) {
            $result = $this->application->setCustomTemplate("bicubic", "hidden");
            $this->application->setHTMLVariableCustomTemplate($result, "OBJECT-NAME-PROPERTY-NAME", $objectName . "_" . $property["name"]);
            $this->application->setHTMLVariableCustomTemplate($result, "OBJECT-NAME-PROPERTY-VALUE", $value);
            return $this->application->renderCustomTemplate($result);
        } else {
            switch ($property["type"]) {
                case "alpha32" :
                case "alphanumeric" :
                case "date" :
                case "double" :
                case "email" :
                case "int" :
                case "letters" :
                case "long" :
                case "numeric" :
                case "percentage" :
                case "password" :
                case "string" :
                case "string" :
                case "string1" :
                case "string2" :
                case "string4" :
                case "string8" :
                case "string16" :
                case "string24" :
                case "string32" :
                case "string64" :
                case "string128" :
                case "string256" :
                case "string512" :
                case "string1024" :
                case "string2048": {
                        $result = $this->application->setCustomTemplate("bicubic", $property["type"]);
                        $this->application->setHTMLVariableCustomTemplate($result, "PROPERTY-LABEL", $this->lang("lang_" . $property["name"]));
                        $this->application->setHTMLVariableCustomTemplate($result, "PROPERTY-PLACEHOLDER", $this->lang("lang_" . $property["name"] . "placeholder"));
                        $this->application->setHTMLVariableCustomTemplate($result, "OBJECT-NAME-PROPERTY-NAME", $objectName . "_" . $property["name"]);
                        $this->application->setHTMLVariableCustomTemplate($result, "OBJECT-NAME-PROPERTY-VALUE", $value);
                        $this->application->setHTMLVariableCustomTemplate($result, "OBJECT-NAME-PROPERTY-REQUIRED", $property["required"] ? "required" : "");
                        return $this->application->renderCustomTemplate($result);
                        break;
                    }
                case "boolean" : {
                        $result = $this->application->setCustomTemplate("bicubic", $property["type"]);
                        $this->application->setHTMLVariableCustomTemplate($result, "PROPERTY-LABEL", $this->lang("lang_" . $property["name"]));
                        $this->application->setHTMLVariableCustomTemplate($result, "OBJECT-NAME-PROPERTY-NAME", $objectName . "_" . $property["name"]);
                        $this->application->setHTMLVariableCustomTemplate($result, "OBJECT-NAME-PROPERTY-REQUIRED", $property["required"] ? "required" : "");
                        if ($value) {
                            $this->application->setHTMLVariableCustomTemplate($result, "OBJECT-NAME-SELECTED-YES", "selected");
                        } else {
                            $this->application->setHTMLVariableCustomTemplate($result, "OBJECT-NAME-SELECTED-NO", "selected");
                        }
                        return $this->application->renderCustomTemplate($result);
                        break;
                    }
                case "list" : {
                        $result = $this->application->setCustomTemplate("bicubic", "category");
                        $this->application->setHTMLVariableCustomTemplate($result, "PROPERTY-LABEL", $this->lang("lang_" . $property["name"]));
                        $this->application->setHTMLVariableCustomTemplate($result, "OBJECT-NAME-PROPERTY-NAME", $objectName . "_" . $property["name"]);
                        $this->application->setHTMLVariableCustomTemplate($result, "OBJECT-NAME-PROPERTY-REQUIRED", $property["required"] ? "required" : "");
                        $items = $object->__getList(new TransactionManager($this->application->data), $property["name"]);
                        foreach ($items as $item => $text) {
                            $this->application->setHTMLArrayCustomTemplate($result, array(
                                "CATEGORY-VALUE" => $item,
                                "CATEGORY-NAME" => $this->lang($text),
                                "CATEGORY-SELECTED" => ($item == $value) ? "selected" : "",
                            ));
                            $this->application->parseCustomTemplate($result, "CATEGORIES");
                        }
                        return $this->application->renderCustomTemplate($result);
                    }
                case "shortlist" : {
                        $result = $this->application->setCustomTemplate("bicubic", "option");
                        $this->application->setHTMLVariableCustomTemplate($result, "PROPERTY-LABEL", $this->lang("lang_" . $property["name"]));
                        $items = $object->__getList(new TransactionManager($this->application->data), $property["name"]);
                        foreach ($items as $item => $text) {
                            $this->application->setHTMLArrayCustomTemplate($result, array(
                                "OBJECT-NAME-PROPERTY-NAME" => $objectName . "_" . $property["name"],
                                "OPTION-VALUE" => $item,
                                "OPTION-NAME" => $this->lang($text),
                                "OPTION-SELECTED" => ($item == $value) ? "checked" : "",
                                "OBJECT-NAME-PROPERTY-REQUIRED" => $property["required"] ? "required" : "",
                            ));
                            $this->application->parseCustomTemplate($result, "CATEGORIES");
                        }
                        return $this->application->renderCustomTemplate($result);
                    }
            }
        }

        return "";
    }

    public function objectForm(DataObject $object, $callback) {
        $id = $this->application->getUrlParam($this->config("param_id"), "int");
        if ($id) {
            $data = new TransactionManager($this->application->data);
            $object->setId($id);
            $object = $data->getRecord($object);
            if (!$object) {
                $this->error("lang_notvalid");
            }
        }
        $this->application->setMainTemplate("bicubic", "form");
        $objectName = get_class($object);
        $this->application->setVariableTemplate("FORM-ID", $this->application->navigation . "$objectName");
        $this->application->setVariableTemplate("FORM-ACTION", $this->application->getSecureAppUrl($this->application->name, $callback));
        $properties = $object->__getProperties();
        if ($object->__isChild()) {
            $properties = array_merge($properties, $object->__getParentProperties());
        }
        $formContent = "";
        foreach ($properties as $property) {
            $formContent .= $this->objectFormElement($object, $property);
        }
        $this->application->setVariableTemplate("FORM-CONTENT", $formContent);
        $this->application->render();
    }

    public function objectFormSubmit(DataObject $object, $callback) {
        $object = $this->application->getFormObject($object);
        $data = new TransactionManager($this->application->data);
        $data->data->begin();
        if (!$object->getId()) {
            if (!$data->insertRecord($object)) {
                $data->data->rollback();
                $this->error("lang_errordatabase");
            }
        } else {
            if (!$data->updateRecord($object)) {
                $data->data->rollback();
                $this->error("lang_errordatabase");
            }
        }
        $data->data->commit();
        $this->application->redirectToUrl($this->application->getSecureAppUrl($this->application->name, $callback));
    }

}

?>
