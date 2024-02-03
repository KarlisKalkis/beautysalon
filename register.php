<?php 
require_once('config/config.php');
?>

<?php include 'includeformainpages/header.php'?>
    <section class="mh-100" style="background-color: #82216f;">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
              <div class="card" style="border-radius: 1rem;">
                <div class="row g-0">
                  <div class="col-md-6 col-lg-5 d-none d-md-block">
                    <img src="pictures/login_thumblane.jpg"
                      alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                  </div>
                  <div class="col-md-6 col-lg-6 d-flex align-items-center">
                    <div class="card-body p-4 p-lg-5 text-black">
      
                      <form action="user_register.php" method="post">
      
                        <div class="d-flex align-items-center mb-3 pb-1">
                          <span class="h1 fw-bold mb-0">Danielas Beauty</span>
                        </div>
      
                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Create your account</h5>
      
                        <div class="form-outline mb-4">
                          <input type="email" name="email" id="email" class="form-control form-control-lg" required />
                          <label class="form-label" for="email">Email address</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" name="firstname" id="firstname" class="form-control form-control-lg" required />
                            <label class="form-label" for="firstname">First name</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" name="lastname" id="lastname" class="form-control form-control-lg" required />
                            <label class="form-label" for="lastname">Last name</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" name="phonenumber" id="phonenumber" class="form-control form-control-lg" required />
                            <label class="form-label" for="phonenumber">Phone number</label>
                        </div>
      
                        <div class="form-outline mb-4">
                          <input type="password" name="password" id="password" class="form-control form-control-lg" required />
                          <label class="form-label" for="password">Password</label>
                        </div>
      
                        <div class="pt-1 mb-4">
                            <input class="btn btn-dark" type="submit" name="create" id="register" value="Register">
                        </div>


                        <a class="small text-muted" href="index.html">Back to home page</a>
                        <br>
                        <a class="small text-muted" href="#!">Forgot password?</a>
                        <p class="mb-5 pb-lg-2" style="color: #393f81;">Have account<a href="login.php"
                            style="color: #393f81;">come in here</a></p>

                        
                      </form>
      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <?php include 'loginandregisterneeded/scriptsincluded.php'?>
      <script type="text/javascript">
        $(function(){
          $('#register').click(function(e){

            var valid = this.form.checkValidity();
            
            if(valid){

            var email           = $('#email').val();
            var firstname       = $('#firstname').val();
            var lastname        = $('#lastname').val();
            var phonenumber     = $('#phonenumber').val();
            var password        = $('#password').val();


              e.preventDefault();

              $.ajax({
                type: 'POST',
                url: 'register_process.php',
                data: {email: email, firstname: firstname, lastname: lastname, phonenumber: phonenumber, 
                  password: password},


                success: function(data){
                Swal.fire({
                'title': 'Succesfully saved',
                'text': data,
                'icon': 'success'
                })

                },

                error: function(data){
                  Swal.fire({
                  'title': 'You came to error',
                  'text': 'There were errors saving your data',
                  'icon': 'error'
                })
                },
              });
            }else{
            }
          });
          });

      </script>
      
    
    </body>
  
  </html>