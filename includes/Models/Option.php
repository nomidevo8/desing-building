<?php
namespace BuildingDesigner\Models;

class Option {
    
    private $id;
    private $label;
    private $type;
    private $image_url;
    private $description;
    private $meta;

    public function __construct($data) {
        $this->id = $data['id'] ?? '';
        $this->label = $data['label'] ?? '';
        $this->type = $data['type'] ?? 'select';
        $this->image_url = $data['image_url'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->meta = $data['meta'] ?? array();
    }

    public function get_id() {
        return $this->id;
    }

    public function get_label() {
        return $this->label;
    }

    public function get_type() {
        return $this->type;
    }

    public function get_image_url() {
        return $this->image_url;
    }

    public function get_description() {
        return $this->description;
    }

    public function get_meta() {
        return $this->meta;
    }

    public function to_array() {
        return array(
            'id' => $this->id,
            'label' => $this->label,
            'type' => $this->type,
            'image_url' => $this->image_url,
            'description' => $this->description,
            'meta' => $this->meta
        );
    }
}
