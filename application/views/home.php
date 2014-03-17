<!DOCTYPE html>
<html>
<head>
	<title>Qsys | Home</title>
	<?php
		$this->load->view('includes/header');
	?>
  <script type="text/javascript">
    $(document).ready(function(){
      function myviewModel(){
       self = this;

       self.alert = ko.observable(false);
       self.alertMsg = ko.observable();

       self.login = function(){
          $.ajax({
              type: 'post',
              url:'<?php echo base_url("index.php/home/login")?>',
              data: $('#frmlogin').serialize(),
              success: function(data){
                if(data == '2'){
                  self.alert(true);
                  self.alertMsg('System Error. Contact your administrator');
                  setTimeout(function(){
                    self.alert(false);
                  }, 3000);
                }
                else if (data == '12'){
                  window.location.assign('<?php echo base_url("index.php/home/adminDash")?>');
                }
                else if (data == '10'){
                  window.location.assign('<?php echo base_url("index.php/home/receiption")?>');
                }
                else if(data == '3'){
                 self.alert(true);
                 self.alertMsg();
                  self.alertMsg('Incorrect Username and Password combination'); 

                setTimeout(function(){
                  self.alert(false);
                }, 3000);
                }
              },
              fail: function(data){
                self.alert(true);
                self.alertMsg('Error');
              }

          });
       }
      }
       ko.applyBindings(new myviewModel()); 
    });
     

  </script>
</head>
<body>
  	<div class = 'pure-g-r'>
  		<div class = 'home-login pure-u-3-5'>
  			<div class = 'alert alert-info'>
  				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  				Welcome to Qsys!<br/> Remember to comment on the system's usability :-)</br>
  				
  			</div>
  			<form class = 'pure-form' id = 'frmlogin' data-bind = 'submit: login'>
          <div class = 'alert alert-danger' data-bind = 'visible: alert, text: alertMsg'></div>
  				<fieldset class = 'pure-group'>
  					<input class = 'pure-input-1-2' name = 'uname' type = 'text' placeholder = 'Username' required/>
  					<input class = 'pure-input-1-2' name = 'pass' type = 'password' placeholder = 'Password'  required/>
  				</fieldset>
  				<button class = 'pure-button pure-button-primary pure-input-1-2'>Login</button>
  			</form>
  		</div>
  		<div class = 'pure-u-5-5'>
  			<?php
  				//$this->load->view('includes/footer');
  			?>
  		</div>
  	</div>
</body>
</html>