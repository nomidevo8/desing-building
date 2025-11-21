<?php
namespace BuildingDesigner\Models;

class Step {
    
    private $id;
    private $label;
    private $icon;
    private $order;

    public function __construct($data) {
        $this->id = $data['id'] ?? '';
        $this->label = $data['label'] ?? '';
        $this->icon = $data['icon'] ?? '';
        $this->order = $data['order'] ?? 0;
    }

    public function get_id() {
        return $this->id;
    }

    public function get_label() {
        return $this->label;
    }

    public function get_icon() {
        return $this->icon;
    }

    public function get_order() {
        return $this->order;
    }

    public function to_array() {
        return array(
            'id' => $this->id,
            'label' => $this->label,
            'icon' => $this->icon,
            'order' => $this->order
        );
    }
}
