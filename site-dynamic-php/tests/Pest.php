<?php

beforeeach(function() {
   if (array_key_exists('REQUEST_URI', $_SERVER)) {
       unset($_SERVER['REQUEST_URI']);
   }
});
