
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
						
						Welcome  
						
						<?php


				$id=$this->session->userdata('admin');

				$this->db->where('id',$id);
				$info=$this->db->get('password');
				
				$da=$info->row();
				
				echo $da->user;
				


						?>
						
						
						
						
						
						
						
						
						</h1>
                    </div>
					
													
				  
                <div class="col-lg-12">
				
                    <h1 class="page-header">Store List</h1>
					
                </div>
               
			   
			   
				
				
				  
                <div class="col-lg-12">
				
                   <?php foreach($store as $s): ?>
				
				
				
				
				
				<div class="col-lg-4 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="background-color:wheat">
                           
                   	   
							   
							

			
				<a href="#">
					
					
							<h3><strong><?php echo $s['name'] ?><strong></h3>
							<p>Ware House :<?php echo $this->setting->anyName('ware','id',$s['ware'],'name'); ?></p>
							


			</a>
							
							   
                                   
                            
                            </div>
                        </div>
                       
                    </div>
				
				
				
				
				
				
				
				
				
				
					
				
				
				<?php endforeach; ?>
					
                </div>
               
			   
			   
					
					
					
					
					
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

