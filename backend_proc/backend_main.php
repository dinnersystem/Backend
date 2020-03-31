<?php
namespace backend_proc;

class backend_main
{
    public $order_handler;
    public $input;

    public function __construct($input = null)
    {
        $this->require_all(__DIR__ . "/../json");
        $this->require_all(__DIR__ . "/../food/limitable");
        $this->require_all(__DIR__ . "/..");
        $this->input = $input;
    }
    
    function require_all($path)
    {
        foreach (glob("$path/*") as $kid) {
            if (is_dir($kid)) $this->require_all($kid);
            else {
                if (strpos($kid, "backend.php") !== false) continue;
                if (strpos($kid, "backend_main.php") !== false) continue;
                require_once($kid);
            }
        }
    }

    public function run()
    {
        if ($this->input == null) {
            $this->order_handler = new order_handler($_REQUEST);
        } else {
            $this->order_handler = new order_handler($this->input);
        }
        return $this->order_handler->process_order();
    }
}
