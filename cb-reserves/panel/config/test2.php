<!DOCTYPE html>
<html>
  <head>
    <script src="bower_components/webcomponentsjs/webcomponents-lite.js">
    </script>
    
    <title>Defining a Polymer Element from the Main Document</title>
  </head>
  <body>
<link rel="import" href="bower_components/polymer/polymer.html">

<dom-module id="stock-ticker">
<style>
  :host {
    display: block;
  }
</style>
<template>
  xxxxxxxxxx
</template>
<script>
(function() {
  'use strict';

  let MyBehavior = { a:33 };

  class StockTicker {

    // Define behaviors with a getter.
    get behaviors() {
      return [MyBehavior];
    }

    // Element setup goes in beforeRegister instead of createdCallback.
    beforeRegister() {
      this.is = 'stock-ticker';

      // Define the properties object in beforeRegister.
      this.properties = {
        symbols: {
          type: Array,
          value: function() { return []; },
          observer: '_updateQuotes'
        }
      };
    }

    // Define other lifecycle methods as you need.
    ready() { alert("ready"); }
    attached() { alert("attached"); }
    detached() { alert("detached"); }
    attributeChanged() { alert("attributeChanged"); }

    _updateQuotes() {
      // Same as the vanilla component.
    }
  }

  // Register the element using Polymer's constructor.
  Polymer(StockTicker);
})();
</script>
</dom-module>
  
  <stock-ticker></stock-ticker>
  </body>
</html>
