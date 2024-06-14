<?php
class WidVis_Plugin implements ArrayAccess {
    protected $contents;

    public function __construct() {
        $this->contents = array();
    }

    // ArrayAccess functions
    public function offsetSet(mixed $offset, mixed $value): void {
        $this->contents[$offset] = $value;
    }

    public function offsetExists(mixed $offset): bool {
        return isset($this->contents[$offset]);
    }

    public function offsetUnset(mixed $offset): void {
        unset($this->contents[$offset]);
    }

    public function offsetGet(mixed $offset): mixed {
        if( is_callable($this->contents[$offset]) ){
            return $this->contents[$offset]( $this );
        }
        return isset($this->contents[$offset]) ? $this->contents[$offset] : null;
    }

    public function run(){
        $this->contents = apply_filters('widvis_services', $this->contents);
        // Loop on contents
        foreach($this->contents as $key=>$content){
            if( is_callable($content) ){
                $content = $this[$key];
            }
            if( is_object($content) ){
                $reflection = new ReflectionClass($content);
                if($reflection->hasMethod('inject')){
                    $content->inject( $this ); // Inject our container
                }
                if($reflection->hasMethod('run')){
                    $content->run(); // Call run method on object
                }
            }
        }
    }
}