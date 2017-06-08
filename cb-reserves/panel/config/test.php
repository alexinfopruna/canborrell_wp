<!DOCTYPE html>
<html>
  <head>
    <script src="bower_components/webcomponentsjs/webcomponents-lite.js">
    </script>
    <link rel="import" href="bower_components/polymer/polymer.html">
    <title>Defining a Polymer Element from the Main Document</title>
  </head>
  <body>
<dom-module id="x-custom">

  <template>
    <input value="{{searchString::input}}">
aaaaaaaaaaaaaaaaaa
    <!-- computeFilter returns a new filter function whenever searchString changes -->
    <template is="dom-repeat" items="{{employees}}" as="employee"
        filter="{{computeFilter(searchString)}}">
        <div>{{employee.lastname}}, {{employee.firstname}}</div>
    </template>
  </template>

  <script>
    class XCustom extends Polymer.Element {

 createdCallback() {
    // This element uses Shadow DOM.
alert("createdCallback");
    // Update the ticker prices.
    //this.updateQuotes(); // We'll define this later.
  }


      static get is() { return 'x-custom'; }

      static get properties() {
        return {
          employees: {
            type: Array,
            value() {
              return [
                { firstname: "Jack", lastname: "Aubrey" },
                { firstname: "Anne", lastname: "Elliot" },
                { firstname: "Stephen", lastname: "Maturin" },
                { firstname: "Emma", lastname: "Woodhouse" }
              ]
            }
          }
        }
      }

      computeFilter(string) {
        if (!string) {
          // set filter to null to disable filtering
          return null;
        } else {
          // return a filter function for the current search string
          string = string.toLowerCase();
          return function(employee) {
            var first = employee.firstname.toLowerCase();
            var last = employee.lastname.toLowerCase();
            return (first.indexOf(string) != -1 ||
                last.indexOf(string) != -1);
          };
        }
      }
    }

      Polymer(XCustom);
  </script>
</dom-module>
    <x-custom></x-custom>
  </body>
</html>
Define a legacy element

