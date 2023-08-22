<?php 
//session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <!--title></title-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--meta name="viewport" content="width=device-width, initial-scale=1.0"-->
    <!-- bootstrap -->
    <link href="tabel/css/bootstrap.css" rel="stylesheet" />
    <link href="tabel/css/bootstrap-overrides.css" type="text/css" rel="stylesheet" />
    <!-- theme -->
    <!--link rel="stylesheet" type="text/css" href="css/theme/default.css" /-->
    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="tabel/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="tabel/css/elements/dataTables.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="tabel/css/elements/tables.css" />
    <link rel="stylesheet" type="text/css" href="tabel/css/elements/form.css" />
    <link rel="stylesheet" type="text/css" href="tabel/css/elements/bootstrap-wysihtml5.css" />
    <!-- open sans font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400italic,700italic,400,700" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
      <script src="js/html5.js"></script>
    <![endif]-->
</head>
<body>   
    <!-- main container -->
    <div class="content">
        <div id="pad-wrapper">
        <?php           
			include "tabel.php";
        ?>
        </div><!-- /pad-wrapper -->
    </div><!-- content --> 
    <!-- /main container -->

    <!--post modal-->
            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h4><strong>Delete Confirmation</strong></h4>
                        </div>
                    
                        <div class="modal-body"><p></p></div>
                       
                        <div class="modal-footer">
                            <button class="btn btn-default btn-sm" data-dismiss="modal" aria-hidden="true">Close</button>
                            <button data-dismiss="modal" class="btn btn-danger btn-sm" id="btnYes">Confirm</button> 
                        </div>
                    </div>
                </div>
            </div>

    <!-- scripts -->
    <script src="tabel/js/jquery.min.js"></script>
    <script src="tabel/js/bootstrap.js"></script>
    <script src="tabel/js/theme.js"></script>

    <script src="tabel/js/dashboard/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="tabel/js/dashboard/jquery-jvectormap-world-mill-en.js"></script>
    <script src="tabel/js/dashboard/jquery.sparkline.min.js"></script>

    <script src="tabel/js/dashboard/waypoints.min.js"></script>
    <script src="tabel/js/dashboard/jquery.counterup.min.js"></script>
    <script src="tabel/js/bootstrap-modal.js"></script>

    <script src="tabel/js/flot/jquery.flot.js"></script>
    <script src="tabel/js/flot/jquery.flot.resize.js"></script>

    <script src="tabel/js/tables/jquery.jeditable.js"></script>
    <script src="tabel/js/tables/jquery.dataTables.js"></script>
    <script src="tabel/js/tables/dataTables.bootstrap.js"></script>

    <script src="tabel/js/form/app.js"></script>
    <script src="tabel/js/form/app.plugin.js"></script>
    <script src="tabel/js/form/datepicker/bootstrap-datepicker.js"></script>
    <script src="tabel/js/form/slider/bootstrap-slider.js"></script>
    <script src="tabel/js/form/bootstrap.file-input.js"></script>    
    <script src="tabel/js/form/combodate/moment.min.js"></script>
    <script src="tabel/js/form/combodate/combodate.js"></script>
    <script src="tabel/js/form/parsley/parsley.min.js"></script>

    <script src="tabel/js/tables/jquery.peity.min.js"></script>
    <script src="tabel/js/tables/peity-demo.js"></script>
    <script src="tabel/js/tables/icheck.min.js"></script>

    <!--wysiwyg editor -->
    <script src="tabel/js/editor/wysihtml5-0.3.0.js"></script>
    <script src="tabel/js/editor/bootstrap3-wysihtml5.js"></script>


     <script type="text/javascript">
        //wysihtml5
       $('.textarea').wysihtml5({
        "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
        "emphasis": true, //Italics, bold, etc. Default true
        "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
        "html": true, //Button which allows you to edit the generated HTML. Default false
        "link": true, //Button to insert a link. Default true
        "image": true, //Button to insert an image. Default true,
        "color": false, //Button to change color of font
        "size": 'sm' //Button size like sm, xs etc.
    });


            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            });
        </script>



    <script type="text/javascript">
       $(document).ready(function() {
            $('.dataTables-example').dataTable();

            /* Init DataTables */
            var oTable = $('#editable').dataTable();

            /* Apply the jEditable handlers to the table */
            oTable.$('td').editable( 'example_ajax.html', {
                "callback": function( sValue, y ) {
                    var aPos = oTable.fnGetPosition( this );
                    oTable.fnUpdate( sValue, aPos[0], aPos[1] );
                },
                "submitdata": function ( value, settings ) {
                    return {
                        "row_id": this.parentNode.getAttribute('id'),
                        "column": oTable.fnGetPosition( this )[2]
                    };
                },

                "width": "90%"
            } );


        });

        function fnClickAddRow() {
            $('#editable').dataTable().fnAddData( [
                "Custom row",
                "New row",
                "New row",
                "New row",
                "New row" ] );

        }
    </script>

</body>
</html>