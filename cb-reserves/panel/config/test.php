<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1, user-scalable=yes">

  <title>paper-time-picker Demo</title>
  
  <script src="bower_components/webcomponentsjs/webcomponents-lite.js"></script>

  <link rel="import" href="bower_components/paper-time-picker/paper-time-picker.html">
  <link rel="import" href="bower_components/paper-dialog/paper-dialog.html">
  <link rel="import" href="bower_components/paper-button/paper-button.html">

  <link rel="import" href="bower_components/paper-styles/paper-styles.html">
  
 


</head>
<body unresolved>
  <template is="dom-bind" id="scope">

<compound-timepicker hours="23"></compound-timepicker>

    <section>
      <h1>{{time}}</h1>
      <paper-button class="btn" on-tap="showDialog" raised>Change Time</paper-button>
      <paper-dialog id="dialog" class="paper-time-picker-dialog" modal on-iron-overlay-closed="dismissDialog">
        <paper-time-picker id="picker" time="[[time]]" format24="1"  forceNarrow="true" animated="1"></paper-time-picker>
        <div class="buttons">
          <paper-button dialog-dismiss>CANCEL</paper-button>
          <paper-button dialog-confirm>OK</paper-button>
        </div>
      </paper-dialog>
    </section>
  </template>

  <script>
    (function() {
      var scope = document.querySelector('#scope');
      scope.dismissDialog = function(event) {
        if (event.detail.confirmed) {
          scope.time = scope.$.picker.time;
          // reset the picker to hours
          this.$.picker.view = 'hours';
        }
      };
      scope.showDialog = function() {
        this.$.dialog.toggle();
      };
      document.addEventListener('WebComponentsReady', function() {
        scope.time = '3:30 PM';
        scope.showDialog();
      });
    })();
  </script>

</body>
</html>
