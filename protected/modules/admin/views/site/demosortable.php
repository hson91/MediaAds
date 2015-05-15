<div id="sortable1" class="controls" style="width: 50%; float: left;">
    <div class="item" style="padding: 3px 10px; background: #999; width: auto;">123</div>
    <div class="item" style="padding: 3px 10px; background: #999; width: auto;">456</div>
    <div class="item" style="padding: 3px 10px; background: #999; width: auto;">789</div>
    <div class="item" style="padding: 3px 10px; background: #999; width: auto;">135</div>
    <div class="item abc" href="abc" style="padding: 3px 10px; background: #999; width: auto;">246</div>
</div>
<div id="sortable2" class="controls" style="width: 40%; float: right;">
    <div class="item" style="padding: 3px 10px; background: #666; width: auto;">321</div>
    <div class="item" style="padding: 3px 10px; background: #666; width: auto;">654</div>
    <div class="item" style="padding: 3px 10px; background: #666; width: auto;">987</div>
    <div class="item" style="padding: 3px 10px; background: #666; width: auto;">531</div>
    <div class="item" style="padding: 3px 10px; background: #666; width: auto;">642</div>
</div>
<script>
     $(function() {
        $( "#sortable1, #sortable2" ).sortable({
          connectWith: "#sortable2",
          cursor: "move",
          revert: true,
          //placeholder: "txt-form",
          //activate: function( event, ui ) {alert("activate");console.log("activate");},//Click select
          receive: function( event, ui ) {  
            console.log(ui.item),
            $(".abc").click(function(){
                ui.item.appendTo($('#sortable1'));
                 $('#sortable2').find(ui.item).remove();
            })
            
          },
          
          //remove: function( event, ui ) {console.log("remove");alert('remove')},
          //start: function( event, ui ) {console.log("start");alert('start')},
          //stop: function( event, ui ) {console.log("stop");alert('stop')},
        });
        
});
</script>