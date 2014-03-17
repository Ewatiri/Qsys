<html>
<head>
	<title>Qsys | Receiption</title>
	<?php
		$this->load->view('includes/header');
	?>
	<script type="text/javascript">
	  $(document).ready(function(){
	  	function myviewModel(){
	  		self = this;

	  		self.newClient = ko.observable(false);
	  		self.existingClient = ko.observable(false);
	  		self.newClientPanel = ko.observable("Client Details 1/2");
	  		self.dVisibility = ko.observable(false);
	  		self.cVisibility = ko.observable(true);
	  		self.opened = ko.observable('newClient');
	  		self.clrt = ko.observable(false);
	  		self.clrtmsg = ko.observable();
	  		self.searchalert = ko.observable(false);
	  		self.searchmsg = ko.observable();

	  		self.clients = ko.observableArray();
	  		self.resultable = ko.observable(false);
	  		self.selName = ko.observable();
	  		self.selSno = ko.observable();

	  		self.existingClient2 = ko.observable(false);
	  		self.searchfrm = ko.observable(true);
	  		self.availableQueues = ko.observableArray();

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

	 	 	self.selectClient = function(){
	 	 		//console.log(this);
	 	 		self.selName(this.fname);
	 	 		self.selSno(this.sno);
	 	 		$.ajax({
	 	 			type:'get',
	 	 			url:'<?php echo base_url("index.php/receiption/setlastClient")?>',
	 	 			data:{clientid: this.custid},
	 	 			success: function(data){
	 	 				
	 	 				self.resultable(false);
	 	 				self.searchfrm(false);
	 	 				self.existingClient2(true);
	 	 			},
	 	 			fail: function(data){

	 	 			}
	 	 		});
	 	 	}
	 	 	function clearText(){
	 	 		$('#regno').val('');
	 	 		$('#fname').val('');
	 	 		$('#tel').val('');
	 	 		$('#email').val('');
	 	 		$('#sno').val('');
	 	 		$('#diag').val('');
	 	 	}
	 	 	function clearText2(){
	 	 		$('#regno').val('');
	 	 		$('#fname').val('');
	 	 		$('#tel').val('');
	 	 		$('#email').val('');
	 	 		$('#sno').val('');
	 	 		$('#diag').val('');
	 	 	}
	 	 	self.searchClient = function(){
				$.ajax({
					type: 'post',
					url: '<?php echo base_url("index.php/receiption/searchClient")?>',
					data: $('#frmclientsearch').serialize(),
					dataType: 'json',
					success: function(data){
						if (data == 0){
						  	//self.clients(data);
						  		
						  	//self.getclientAlert(false);
						}
						else if (data == 2){
						  	self.searchmsg("No results found");
						  	self.searchalert(true);
						  	$('#alrt2').removeClass('alert-success');
	  						$('#alrt2').addClass('alert-danger');


	  						setTimeout(function(){
	  							self.searchalert(false);
	  						}, 3000);
						}
						else{
							self.clients(data);
							self.resultable(true);
						}
					},
					fail: function(data){

					}
				});
			}

	  		self.addNewClient = function(){
	  			$.ajax({
	  				type:'get',
	  				url: '<?php echo base_url("index.php/receiption/addNewClient") ?>',
	  				data: $('#addC').serialize(),
	  				success: function(data){
	  					if (data == '1'){
	  						self.dVisibility(true);
	  						self.cVisibility(false);
	  						self.newClientPanel("Queue Details 2/2");
	  					
	  					}
	  					else if (data == '2'){
	  						$('#alrt').removeClass('alert-success');
	  						$('#alrt').addClass('alert-danger');
	  						self.clrt(true);
	  						self.clrtmsg("Serial Number has already been registered");


	  						setTimeout(function(){
	  							self.clrt(false);
	  						}, 3000);
	  					}
	  					else{
	  						$('#alrt').removeClass('alert-success');
	  						$('#alrt').addClass('alert-danger');
	  						self.clrt(true);
	  						self.clrtmsg("An error occurred");

	  						setTimeout(function(){
	  							self.clrt(false);
	  						}, 3000);
	  					}
	  				},
	  				fail: function(data){

	  				}
	  			});
	  		}
	  		self.addtQ = function(){
	  			$.ajax({
	  				type: 'get',
	  				url:'<?php echo base_url("index.php/receiption/addtQueue")?>',
	  				data:$('#frmq').serialize(),
	  				success: function(data){
	  					if (data == '1'){
	  						clearText();
	  						$('#alrt').removeClass('alert-danger');
	  						$('#alrt').addClass('alert-success');
	  						self.clrt(true);
	  						self.clrtmsg("Record added");

	  						self.dVisibility(false);
	  						self.cVisibility(true);
	  						self.newClientPanel("Client Details 1/2");

	  						setTimeout(function(){
	  							self.clrt(false);
	  						}, 3000);
	  					}
	  				},
	  				fail: function(data){

	  				}
	  			});
	  		}

	  		self.qexistingCust = function(){
	  			$.ajax({
	  				type: 'get',
	  				url:'<?php echo base_url("index.php/receiption/addtQueue2")?>',
	  				data:$('#frmq2').serialize(),
	  				success: function(data){
	  					if (data == '1'){
	  						clearText();
	  						$('#alrt2').removeClass('alert-danger');
	  						$('#alrt2').addClass('alert-success');
	  						self.searchalert(true);
	  						self.searchmsg("Record added");

	  						setTimeout(function(){
	  							self.searchalert(false);
	  						}, 3000);
	  					}
	  				},
	  				fail: function(data){

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
		<div class = 'pure-u-5-24'>
			<div class = 'pure-menu pure-menu-open receiption-menu'>
				<a class = 'pure-menu-heading'>Clients</a>
				<ul>
					<li><a href="#" id = 'newClient' data-bind = 'click: openForm'>New Client</a></li>
					<li><a href="#" id = 'existingClient' data-bind = 'click: openForm'>Existing Client</a></li>
					<a class = 'pure-menu-heading'>My Account</a>
					<li><a href="#">Change Password</a></li>
					<li><a href="#">Logout</a></li>
				</ul>
			</div>
		</div>
		<div class = 'pure-u-9-24'>
			<div class = 'panel panel-default' data-bind = 'visible: newClient'>
				<button type="button" class="close" id = 'newClient' data-bind = 'click: closeForm' aria-hidden="true">&times;</button>
				<div class = 'panel-heading'>New Client</div>
				<div class = 'panel-body'>
					<div class = 'panel panel-default' >
						<div class = 'panel-heading' data-bind = 'text: newClientPanel'></div>
						<div class = 'panel-body'>
							<div class = 'alert ' id = 'alrt' data-bind = 'text: clrtmsg, visible: clrt' ></div>
							<form class = 'pure-form' data-bind = 'visible: cVisibility, submit: addNewClient' id = 'addC'>
								<fieldset class = 'pure-group' >
									<input type = 'text' name = 'regno' id = 'regno' placeholder = 'Reg #' class = 'pure-input-1-2' required />
									<input type = 'text' name = 'fname' id = 'fname' placeholder = 'Full Name' class = 'pure-input-1-2' required />
									<input type = 'text' name = 'tel' id = 'tel' placeholder = 'Phone #' class = 'pure-input-1-2' required />
									<input type = 'text' name = 'email' id = 'email' placeholder = 'Email' class = 'pure-input-1-2' required />
									<input type = 'text' name = 'sno' id = 'sno' placeholder = 'Serial #' class = 'pure-input-1-2' required />
								</fieldset>
								<button class = 'pure-button pure-input-1-2'>Next</button>
							</form>
							<form class = 'pure-form' data-bind = 'visible: dVisibility, submit: addtQ' id = 'frmq'>
								<fieldset class = 'pure-group' >
									<textarea class = 'pure-input-1-2' name = 'diag' id = 'diag' placeholder = 'Diagnosis' required></textarea>
									<select name = 'queue1' class = 'pure-input-1-2' data-bind = 'options: availableQueues,optionsText:"qname",optionsValue:"qid"'></select>
								</fieldset>
								<button class = 'pure-button pure-input-1-2' data-bind = 'visible: dVisibility'>Queue</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class = 'panel panel-default' data-bind = 'visible: existingClient'>
				<button type="button" class="close" id = 'existingClient' data-bind = 'click: closeForm' aria-hidden="true">&times;</button>
				<div class = 'panel-heading'>Search Client</div>
				<div class = 'panel-body'>
					<div class = 'alert ' id = 'alrt2' data-bind = 'text: searchmsg, visible: searchalert' ></div>
					<form class = 'pure-form' id = 'frmclientsearch' data-bind = 'submit: searchClient,visible: searchfrm'>
						<input class = 'pure-input-rounded' placeholder = 'Reg #' name = 'sregno' required />
						<button class = 'pure-button'>Search</button>
					</form>
					<br/>
					<table class = 'pure-table' data-bind = 'visible: resultable'>
						<thead>
							<tr>
								<td>Registration Number</td>
								<td>Full Name</td>
								<td>Serial Number</td>
								<td></td>
							</tr>
						</thead>
						<tbody data-bind = 'foreach: clients'>
							<tr>
								<td data-bind = 'text: regno'></td>
								<td data-bind = 'text: fname'></td>
								<td data-bind = 'text: sno'></td>
								<td><button class = 'pure-button' type = 'button' data-bind = 'click:$parent.selectClient'>Select</button></td>
							</tr>
						</tbody>
					</table>
					<div data-bind = 'visible: existingClient2'>
						<div class= 'alert alert-info' >
							Client Name: <span data-bind = 'text: selName '></span> <br/>
							Serial Number: <span data-bind = 'text: selSno'></span>
						</div>
						<form class = 'pure-form' data-bind = 'submit: qexistingCust' id = 'frmq2'>
							<textarea name = 'diag2' placeholder = 'Diagnosis' class = 'pure-input-1-2' required></textarea>
							<select name = 'queue2' class = 'pure-input-1-2' data-bind = 'options: availableQueues,optionsText:"qname",optionsValue:"qid"'></select>
							<button class = 'pure-button'>Queue</button>
						</form>
					</div>
					

				</div>
			</div>
		</div>

		<div class = 'pure-u-9-24'>
			
		</div>

	</div>
</body>
</html>