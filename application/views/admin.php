<!DOCTYPE html>
<html>
<head>
	<title>Qsys | Admin Dashboard</title>
	<?php

		$this->load->view('includes/header');
	?>
	<script type="text/javascript">
	 $(document).ready(function(){
	 	 function myviewModel(){
	 	 	self = this;
	 	 	// vars needed

	 	 	self.qmng = ko.observable();
	 	 	self.umng = ko.observable(false);
	 	 	self.viewQ = ko.observable(false);
	 	 	self.opened = ko.observable('qmng');
	 	 	self.sqalert = ko.observable(false);
	 	 	self.sqalertMsg = ko.observable("");
	 	 	self.availableQueues = ko.observableArray('');
	 	 	self.newQ = ko.observable();

	 	 	self.roles = ko.observableArray(['Receiptionist','Server','Administrator']);
	 	 	self.selectedRole = ko.observableArray();
	 	 	self.userForm = ko.observable(false);
	 	 	self.uformMsg = ko.observable();
	 	 	self.users = ko.observableArray('');

	 	 	self.helloThis = function(data,event){
 	 			console.dir(event.target);
	 	 	}

	 	 	self.selectedRole.subscribe(function(data){
	 	 		if (data == 'Server'){
	 	 			self.viewQ(true);	
	 	 		}
	 	 		else{
	 	 			self.viewQ(false);
	 	 		}
	 	 		
	 	 	});
	 	 	$.ajax({
	 	 		type: 'get',
	 	 		url: '<?php echo base_url("index.php/admin/fetchQs")?>',
	 	 		dataType: 'json',
	 	 		success: function(data){
	 	 			if (data != 0){
	 	 				$.each(data,function(index,dt){
                            self.availableQueues.push(dt);

                        });
	 	 			}
	 	 			console.log(self.availableQueues());
	 	 		},
	 	 		fail: function (data){

	 	 		}
	 	 	});

	 	 	self.openForm = function(data,event){
	 	 		var id = event.target.id;
	 			self[self.opened()]((false));

	 	 		self[id]((true));
	 	 		self.opened(id);
	 	 		//console.log(id);
	 	 	}

	 	 	self.closeForm = function(data,event){
	 	 		var id = event.target.id;

	 	 		self[id]((false));
	 	 		//console.log(id+"2");
	 	 		//console.log(self.qmng());
	 	 	}
	 	 	self.deleteQueue = function(){
	 	 		var rmv = this;
	 	 		$.ajax({
	 	 			type:'get',
	 	 			url:'<?php echo base_url("index.php/admin/deleteQs/") ?>',
	 	 			data: {qname:this},
	 	 			success: function(data){
	 	 				if (data == '1'){
	 	 					self.availableQueues.remove(rmv);
	 	 				}
	 	 			},
	 	 			fail: function(data){

	 	 			}
	 	 		});
	 	 		
	 	 	}
	 	 	self.saveQueue = function(){
	 	 		add = $('#qname').val();
	 	 		$.ajax({
	 	 			type:'get',
	 	 			url:"<?php echo base_url('index.php/admin/addQueue/')?>",
	 	 			data:$('#saveQ').serialize(),
	 	 			success:function(data){
	 	 				if (data == '1'){
	 	 					$('#sqalert').removeClass('alert-danger');
	 	 					$('#sqalert').addClass('alert-success');
	 	 					self.availableQueues.push({qname:self.newQ()});
	 	 					console.log(self.availableQueues());
	 	 					self.sqalertMsg("Queue Added");
	 	 					self.sqalert(true);	
	 	 				}
	 	 				else if (data == '2'){
	 	 					$('#sqalert').removeClass('alert-success');
	 	 					$('#sqalert').addClass('alert-danger');
	 	 					self.sqalertMsg("The queue exists");
	 	 					self.sqalert(true);	
	 	 				}
	 	 				else{
	 	 					$('#sqalert').removeClass('alert-success');
	 	 					$('#sqalert').addClass('alert-danger');
	 	 					self.sqalertMsg("An Error Occurred");
	 	 					self.sqalert(true);
	 	 				}
	 	 				
	 	 			},
	 	 			fail: function(data){
	 	 				$('#sqalert').removeClass('alert-success');
	 	 				$('#sqalert').addClass('alert-danger');
	 	 				self.sqalertMsg("An Error Occurred");
	 	 				self.sqalert(true);
	 	 			}
	 	 		});
	 	 	}

	 	 	function checkers(pass1,pass2){
	 	 		if (pass1 == pass2){
	 	 			return 1;
	 	 		}
	 	 		else{
	 	 			return 0;
	 	 		}
	 	 	}
	 	 	
	 	 	self.saveUser = function(){
	 	 		pass1 = $('#dpass').val();
	 	 		pass2 = $('#dpass2').val();

	 	 		if (checkers(pass1,pass2) == 1){
	 	 			$.ajax({
	 	 				type: 'post',
	 	 				url: '<?php echo base_url("index.php/admin/newUser")?>',
	 	 				data: $('#frmaddUser').serialize(),
	 	 				success: function(data){
	 	 					if (data == '1'){
	 	 						$('#useralert').removeClass('alert-danger');
	 	 						$('#useralert').addClass('alert-success');
	 	 						self.uformMsg("User Added");
	 	 						self.userForm(true);
	 	 						console.log(data);
	 	 					}
	 	 					else if (data == '2'){
	 	 						$('#useralert').removeClass('alert-success');
	 	 						$('#useralert').addClass('alert-danger');
	 	 						self.uformMsg("The username already exists");
	 	 						self.userForm(true);
	 	 						console.log(data);
	 	 					}
	 	 					else{
	 	 						$('#useralert').removeClass('alert-success');
	 	 						$('#useralert').addClass('alert-danger');
	 	 						self.uformMsg("An error occured");
	 	 						self.userForm(true);
	 	 						console.log(data);
	 	 					}
	 	 				},
	 	 				fail: function(data){

	 	 				}
	 	 			});
	 	 		}
	 	 	}

	 	 }
	 	 ko.applyBindings(new myviewModel());
	 });
	</script>
</head>
<body>
	<div class = 'content pure-g-r'>
		<div class = 'pure-u-5-24'>
			<div class = 'pure-menu pure-menu-open admin-menu'>
				<a class = 'pure-menu-heading'>Queues</a>
				<ul>
					<li><a href="#" id = 'qmng' data-bind ="click: openForm">Queue Management</a></li>
					<a class = 'pure-menu-heading'>Users</a>
					<li><a href="#" id = 'umng' data-bind = 'click: openForm'>User Management</a></li>
					<a class = 'pure-menu-heading'>Reports</a>
					<li><a href="#">Financial/Serving Reports</a></li>
					<a class = 'pure-menu-heading'>My Account</a>
					<li><a href="#">Change Password</a></li>
					<li><a href="#">Logout</a></li>
					<a class = 'pure-menu-heading'>System Status</a>
					<li><a href="#">Lock/Unlock System</a></li>
				</ul>
			</div>
		</div>
		<div class = 'pure-u-19-24 '>
			<div class = 'panel panel-default' data-bind = 'visible: qmng'>
				<button type="button" class="close" id = 'qmng' data-bind = 'click: closeForm' aria-hidden="true">&times;</button>
				<div class = 'panel-heading'>Queue Management</div>
				<div class = 'panel-body'>
					<div class = 'panel panel-default pure-u-9-24 admin-add'>
						<div class = 'panel-heading'>Add a Queue</div>
						<div class = 'panel-body'>
							<form class = 'pure-form' id = 'saveQ' data-bind = 'submit: saveQueue'>
								<div class = 'alert' id = 'sqalert' data-bind = 'visible: sqalert, text:sqalertMsg'></div>
								<fieldset class = 'pure-group'>
									<input class = 'pure-input-1-2' type = 'text' name = 'qname' data-bind = 'value: newQ' id = 'qname' placeholder = 'Queue Name' required/>
								</fieldset>
								<button class = 'pure-button pure-input-1-2' type = 'submit'>Add</button>
							</form>
						</div>
					</div>
					<div class = 'panel panel-default pure-u-9-24 admin-q'>
						<div class = 'panel-heading'>Existing Queues</div>
						<div class = 'panel-body'>
							<ul data-bind = 'foreach: availableQueues'>
								<li>
									<span data-bind = 'text: qname'></span>
									<button type="button" class="close"  data-bind = 'click: $parent.deleteQueue' aria-hidden="true">&times;</button>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class = 'panel panel-default' data-bind = 'visible: umng' >
				<button type="button" class="close" id = 'umng' data-bind = 'click: closeForm' aria-hidden="true">&times;</button>
				<div class = 'panel-heading'>User Management</div>
				
				<div class = 'panel-body'>
					<div class = 'panel panel-default pure-u-10-24'>
						<div class = 'panel-heading'>Add New Users</div>
						<div class = 'panel-body'>
							<form class = 'pure-form' id = 'frmaddUser' data-bind = 'submit: saveUser'>
								<div class = 'alert' id = 'useralert' data-bind = 'visible: userForm, text:uformMsg'></div>
								<fieldset class = 'pure-group'>
									<input class = 'pure-input-1-2' type = 'text' placeholder = 'User Name' name = 'uname'  />
									<input class = 'pure-input-1-2' type = 'password' placeholder = 'Default Password' name = 'dpass' id = 'dpass' />
									<input class = 'pure-input-1-2' type = 'password' placeholder = 'Confirm Default Password' name = 'dpass2' id = 'dpass2' />
									<select name = 'rid' class = 'pure-input-1-2' data-bind = "options: roles, selectedOptions: selectedRole" required>
									</select>
									<select name = 'queuename' class = 'pure-input-1-2' data-bind = 'visible: viewQ ,options: availableQueues,optionsText:"qname",optionsValue:"qid"' >
										
									</select>
								</fieldset>
								<button class = 'pure-button pure-input-1-2'>Add</button>
							</form>
						</div>
					</div>
					<div class = 'panel panel-default pure-u-9-24'>
						<div class = 'panel-heading'>Switch Roles</div>
						<div class = 'panel-body'>
						</div>
					</div>
					<div class = 'panel panel-default pure-u-9-24'>
						<div class = 'panel-heading'>Delete Users</div>
						<div class = 'panel-body'>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>