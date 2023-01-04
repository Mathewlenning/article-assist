<div class="container-fluid m-5">
    <div class="row d-flex justify-content-center">
        <div class="col-6">
            <h2>What is Article Assistant?</h2>
            <p>Article Assistant is a simple tool to help outline and write articles.</p>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-3 p-0">
            <form method="POST" action="/" data-vdt="user" onsubmit="validateForm(event)">
                    @include('index.login.form')
                <div class="collapse js-toggle-collapse">
                    @include('index.registration.form')
                </div>

                <div class="js-login-controls mb-2">
                    <div class="row d-flex justify-content-center" >
                        <div class="col-5"><input type="submit" value="Login" class="btn btn-primary btn-lg btn-block"/></div>
                        <div class="col-2 ml-0 mr-0 text-center h4">OR</div>
                        <div class="col-5"><a class="btn btn-outline-secondary btn-lg btn-block" onclick="toggleRegistration()">Register</a></div>
                    </div>
                </div>
                <div class="js-login-controls display-none">
                    <div class="row d-flex justify-content-center mb-2" >
                        <div class="col-5"><a class="btn btn-outline-secondary btn-lg btn-block" onclick="toggleRegistration()">Login</a></div>
                        <div class="col-2 ml-0 mr-0 text-center h4">OR</div>
                        <div class="col-5"><input type="submit" value="Submit" class="btn btn-primary btn-lg btn-block"/></div>
                    </div>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
<script>
    function toggleRegistration(){
        jQuery('.js-toggle-collapse').collapse('toggle');
        jQuery('.js-login-controls').toggleClass('display-none');
    }
</script>
