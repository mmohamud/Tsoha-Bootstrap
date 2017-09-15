<?php

  class HelloWorldController extends BaseController{

    public static function etusivu(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make("suunnitelmat/frontpage.html");
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      View::make("helloworld.html");
    }
    
    public static function äänestyssivu() {
      View::make("suunnitelmat/vote_list.html");
    }

    public static function esittelysivu() {
      View::make("suunnitelmat/vote_show.html");
    }

    public static function muokkaussivu() {
      View::make("suunnitelmat/vote_edit.html");
    }

    public static function kirjautumissivu() {
      View::make("suunnitelmat/login.html");
    }

    public static function rekisteröitymissivu() {
      View::make("suunnitelmat/reg.html");
    }

    public static function uusiÄänestys() {
      View::make("suunnitelmat/vote_create.html");
    }
  }
