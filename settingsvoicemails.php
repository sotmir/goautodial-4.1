<?php	

    ###################################################
    ### Name: settingsvoicemails.php                ###
    ### Functions: Manage Voicemails                ###
    ### Copyright: GOAutoDial Ltd. (c) 2011-2016    ###
    ### Version: 4.0                                ###
    ### Written by: Alexander Jim H. Abenoja        ###
    ### License: AGPLv2                             ###
    ###################################################

	require_once('./php/UIHandler.php');
	require_once('./php/CRMDefaults.php');
    require_once('./php/LanguageHandler.php');
    include('./php/Session.php');

	$ui = \creamy\UIHandler::getInstance();
	$lh = \creamy\LanguageHandler::getInstance();
	$user = \creamy\CreamyUser::currentUser();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Voicemails</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <?php print $ui->standardizedThemeCSS(); ?> 

        <?php print $ui->creamyThemeCSS(); ?>
        
        <!-- DATA TABLES -->
        <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- Data Tables -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

    </head>
    <?php print $ui->creamyBody(); ?>
        <div class="wrapper">
        <!-- header logo: style can be found in header.less -->
		<?php print $ui->creamyHeader($user); ?>
            <!-- Left side column. contains the logo and sidebar -->
			<?php print $ui->getSidebar($user->getUserId(), $user->getUserName(), $user->getUserRole(), $user->getUserAvatar()); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php $lh->translateText("settings"); ?>
                        <small><?php $lh->translateText("voice_mails_management"); ?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./index.php"><i class="fa fa-phone"></i> <?php $lh->translateText("home"); ?></a></li>
                        <li><?php $lh->translateText("settings"); ?></li>
						<li class="active"><?php $lh->translateText("voice_mails"); ?>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <?php if ($user->userHasAdminPermission()) { ?>
                    <div class="panel panel-default">
                        <div class="panel-body table" id="scripts_table">
                            <legend>Voicemails</legend>
							<?php print $ui->getVoiceMails(); ?>
                        </div>
                    </div> 
				<!-- /fila con acciones, formularios y demás -->
				<?php
					} else {
						print $ui->calloutErrorMessage($lh->translationFor("you_dont_have_permission"));
					}
				?>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <div class="action-button-circle" data-toggle="modal" data-target="#addvoicemail-modal">
            <?php print $ui->getCircleButton("voicemails", "plus"); ?>
        </div>

<?php
 /*
  * APIs needed for form
  */
   $user_groups = $ui->API_goGetUserGroupsList();
?>
    <!-- ADD USER GROUP MODAL -->
        <div class="modal fade" id="addvoicemail-modal" tabindex="-1" aria-labelledby="addvoicemail-modal" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                <!-- Header -->
                    <div class="modal-header">
                        <h4 class="modal-title animated bounceInRight" id="ingroup_modal">
                            <b>Voice Mail Wizard » Add New Voice Mail</b>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </h4>
                    </div>
                    <div class="modal-body">
                    
                    <form action="" method="POST" id="create_voicemail" name="create_voicemail" role="form">
                        <div class="row">
                    <!-- STEP 1 -->
                            <h4>
                                <small></small>
                            </h4>
                            <fieldset>
                                <div class="form-group mt">
                                    <label class="col-sm-3 control-label" for="voicemail_id">Voicemail ID</label>
                                    <div class="col-sm-9 mb">
                                        <input type="number" name="voicemail_id" id="voicemail_id" class="form-control" placeholder="Voicemail ID (Mandatory)" minlength="2" maxlength="10">
                                    </div>
                                </div>
                                <div class="form-group">        
                                    <label class="col-sm-3 control-label" for="password">Password: </label>
                                    <div class="col-sm-9 mb">
                                        <input type="text" name="password" id="password" class="form-control" placeholder="Password (Mandatory)" required>
                                    </div>
                                </div>
                                <div class="form-group">        
                                    <label class="col-sm-3 control-label" for="name">Name </label>
                                    <div class="col-sm-9 mb">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name (Mandatory)" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="active">Active </label>
                                    <div class="col-sm-9 mb">
                                        <select name="active" id="active" class="form-control">
                                            <option value="N" selected>No</option>
                                            <option value="Y">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">        
                                    <label class="col-sm-3 control-label" for="email">Email </label>
                                    <div class="col-sm-9 mb">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="user_group">User Group </label>
                                    <div class="col-sm-9 mb">
                                        <select id="user_group" class="form-control" name="user_group">
                                            <?php
                                                for($i=0;$i<count($user_groups->user_group);$i++){
                                            ?>
                                                <option value="<?php echo $user_groups->user_group[$i];?>">  <?php echo $user_groups->user_group[$i].' - '.$user_groups->group_name[$i];?>  </option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                        </div><!-- end of step -->
                    
                    </form>

                    </div> <!-- end of modal body -->
                </div>
            </div>
        </div><!-- end of modal -->
        
    <!-- Forms and actions -->
        <?php print $ui->standardizedThemeJS(); ?>
        <!-- JQUERY STEPS-->
        <script src="theme_dashboard/js/jquery.steps/build/jquery.steps.js"></script>

<script>
    $(document).ready(function() {

        /*********************
        ** INITIALIZATION
        *********************/

            // init data table
                $('#voicemails_table').dataTable();

            // init form wizard 
                var form = $("#create_voicemail"); 
                form.validate({
                    errorPlacement: function errorPlacement(error, element) { element.after(error); }
                });

            /*********
            ** Init Wizard
            *********/
                form.children("div").steps({
                    headerTag: "h4",
                    bodyTag: "fieldset",
                    transitionEffect: "slideLeft",
                    onStepChanging: function (event, currentIndex, newIndex)
                    {
                        // Allways allow step back to the previous step even if the current step is not valid!
                        if (currentIndex > newIndex) {
                            return true;
                        }

                        // Clean up if user went backward before
                        if (currentIndex < newIndex)
                        {
                            // To remove error styles
                            $(".body:eq(" + newIndex + ") label.error", form).remove();
                            $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                        }

                        form.validate().settings.ignore = ":disabled,:hidden";
                        return form.valid();
                    },
                    onFinishing: function (event, currentIndex)
                    {
                        form.validate().settings.ignore = ":disabled";
                        return form.valid();
                    },
                    onFinished: function (event, currentIndex)
                    {
                        $('#finish').text("Loading...");
                        $('#finish').attr("disabled", true);

                        // Submit form via ajax
                            $.ajax({
                                url: "./php/AddVoicemail.php",
                                type: 'POST',
                                data: $("#create_voicemail").serialize(),
                                success: function(data) {
                                  // console.log(data);
                                      if(data == 1){
                                            swal({title: "Success",text: "Voicemail Successfully Created!",type: "success"},function(){window.location.href = 'settingsvoicemails.php';});
                                            $('#finish').val("Submit");
                                      }
                                      else{
                                          sweetAlert("Oops...", "Something went wrong! "+data, "error");
                                          $('#finish').val("Submit");
                                          $('#finish').prop("disabled", false);
                                      }
                                }
                            });
                    }
                });
 
        /*********************
        ** EDIT EVENT
        *********************/
            $(document).on('click','.edit-voicemail',function() {
                var url = './editsettingsvoicemail.php';
                var vmid = $(this).attr('data-id');
                var form = $('<form action="' + url + '" method="post"><input type="hidden" name="vmid" value="'+vmid+'" /></form>');
                //$('body').append(form);  // This line is not necessary
                $(form).submit();
            });

        /*********************
        ** DELETE EVENT
        *********************/  
            $(document).on('click','.delete-voicemail',function() {
                var id = $(this).attr('data-id');
                    swal({   
                        title: "Are you sure?",   
                        text: "This action cannot be undone.",   
                        type: "warning",   
                        showCancelButton: true,   
                        confirmButtonColor: "#DD6B55",   
                        confirmButtonText: "Yes, delete this voicemail!",   
                        cancelButtonText: "No, cancel please!",   
                        closeOnConfirm: false,   
                        closeOnCancel: false 
                        }, 
                        function(isConfirm){   
                            if (isConfirm) { 
                                $.ajax({
                                    url: "./php/DeleteVoicemail.php",
                                    type: 'POST',
                                    data: { 
                                        voicemail_id:id,
                                    },
                                    success: function(data) {
                                    console.log(data);
                                        if(data == 1){
                                            swal({title: "Deleted",text: "Voicemail Successfully Deleted!",type: "success"},function(){window.location.href = 'settingsvoicemails.php';});
                                        }else{
                                            sweetAlert("Oops...", "Something went wrong! "+data, "error");
                                        }
                                    }
                                });
                            } else {     
                                    swal("Cancelled", "No action has been done :)", "error");   
                            } 
                        }
                    );
            });
        /*********************
        ** FILTERS
        *********************/  

            // disable special characters on Usergroup ID   
                $('#voicemail_id').bind('keypress', function (event) {
                    var regex = new RegExp("^[ A-Za-z0-9]+$");
                    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                    if (!regex.test(key)) {
                       event.preventDefault();
                       return false;
                    }
                });

            // disable special characters on Usergroup Name
                $('#name').bind('keypress', function (event) {
                    var regex = new RegExp("^[a-zA-Z0-9 ]+$");
                    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
                    if (!regex.test(key)) {
                       event.preventDefault();
                       return false;
                    }
                });
    });
</script>
    
        <?php print $ui->creamyFooter();?>
    </body>
</html>
