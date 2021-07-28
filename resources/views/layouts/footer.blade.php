<div class="bg-dark text-white">
        <div class="container py-5">
                <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                                <img src="{{ asset('/img/logo.png') }}" width="64" height="64" class="d-inline-block align-top" alt="">
                                <h4 class="mt-2">Falcon Printing System</h4>
                                <p>F-PRINT is a web-based printing management system for the business affairs office in Adamson University that will reduce the problem of queuing in line in traditional printing services. The proposed system has a systematic and organized flow of importing files. It will be efficient and accessible for the use of Adamson Community since it is online-based.</p>
                        </div>
                        <div class="col-12 col-lg-4 mb-3">
                                <h5 class="text-lg-center mb-4 mb-lg-0">Find us on Social Media</h5>
                                <div class="pt-lg-4 d-flex flex-row justify-content-lg-center">
                                        <a id="icon-facebook" class="pad-icon" href="#"> 
                                                <p>
                                                        <i class="fab fa-facebook-f text-white"></i>
                                                </p> 
                                        </a>
                                        <a id="icon-twitter" class="pad-icon" href="#"> 
                                                <p>
                                                        <i class="fab fa-twitter text-white" ></i>
                                                </p> 
                                        </a>
                                        <a id="icon-instagram" class="pad-icon" href="#"> 
                                                <p>
                                                        <i class="fab fa-instagram text-white"></i>
                                                </p> 
                                        </a>
                                </div>
                        </div>
                        <div class="col-12 col-lg-4">
                                <h5 class="mb-3">Contact Us</h5>
                                <table id="footer-contactus" class="table-responsive">
                                        <tr>
                                                <td width="50px">
                                                        <i class="footer-icon fa fa-map-marker-alt" aria-hidden="true"></i>
                                                </td>
                                                <td>
                                                        <p class="m-0">900 San Marcelino St, Ermita,<br>
                                                                Manila, 1000 Metro Manila</p>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                        <i class="footer-icon fa fa-phone" aria-hidden="true"></i>
                                                </td>
                                                <td>
                                                        <p class="m-0">(02) 8254-2011</p>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                        <i class="footer-icon fa fa-envelope" aria-hidden="true"></i>
                                                </td>
                                                <td>
                                                        <p class="m-0">webmaster@adamson.edu.ph</p>
                                                </td>
                                        </tr>
                                </table>                            
                                
                        </div>        
                </div>
        </div>
</div>





<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
 
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>


<script type="text/javascript">

$(document).ready(function() { 
        $('#userTable').DataTable({}); 
        $('#orderTable').DataTable({});
        $('#priceTable').DataTable({});
        $('#myOrderTable').DataTable({});
        // $('#orderFormTable').DataTable({});

});

</script>

</body>
</html>