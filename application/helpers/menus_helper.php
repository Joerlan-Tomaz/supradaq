<?php

namespace helpers;

class Menus {

    private $id_menu;

    public function getIdMenu() {
        return $this->id_menu;
    }

    public function setIdMenu($id_menu) {
        $this->id_menu = $id_menu;
    }

    public static function is_menu($array) {
        return $array['parent_id'] == null;
    }

    public static function is_sub_menu($array) {
        return $array['parent_id'] != null;
    }

    public static function set_submenu($array, $id_menu) {
        $menu = new Menus();
        $menu->setIdMenu($id_menu);
        return array_filter($array, array($menu, 'is_respective_submenu'));
    }

    public function is_respective_submenu($elemento) {
        return $elemento['parent_id'] == $this->id_menu;
    }

}
