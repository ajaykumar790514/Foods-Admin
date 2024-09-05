
                </div>
            </div>
        </div>
<!-- Required Jquery -->
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/popper.js/popper.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap/js/bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>
<!-- modernizr js -->
<script type="text/javascript" src="<?=base_url();?>assets/js/modernizr/modernizr.js"></script>
<!-- am chart -->
<script src="<?=base_url();?>assets/pages/widget/amchart/amcharts.min.js"></script>
<script src="<?=base_url();?>assets/pages/widget/amchart/serial.min.js"></script>
<!-- Chart js -->
<script type="text/javascript" src="<?=base_url();?>assets/js/chart.js/Chart.js"></script>
<!-- Todo js -->
<script type="text/javascript " src="<?=base_url();?>assets/pages/todo/todo.js "></script>
<!-- Custom js -->
<!-- <script type="text/javascript" src="assets/pages/dashboard/custom-dashboard.min.js"></script> -->
<script type="text/javascript" src="<?=base_url();?>assets/js/script.js"></script>
<script type="text/javascript " src="<?=base_url();?>assets/js/SmoothScroll.js"></script>
<script src="<?=base_url();?>assets/js/pcoded.min.js"></script>
<script src="<?=base_url();?>assets/js/vartical-demo.js"></script>
<script src="<?=base_url();?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- Include Toastr.js from CDN -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="//cdn.ckeditor.com/4.10.0/full-all/ckeditor.js"></script>

<!-- Include jQuery -->
<div class="modal fade text-left" id="showModal-xl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel21" aria-hidden="true" style="z-index: 999999;">
  <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel21">......</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              
          </div>
          <!-- <div class="modal-footer">
              <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
          </div> -->
      </div>
  </div>
</div>


<div class="modal fade text-left" id="showModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel21" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel21">......</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              
          </div>
     <div class="modal-footer">
              
          </div> 
      </div>
  </div>
</div>

<div class="modal fade text-left" id="showModal-sm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel21" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-body" style="overflow:hidden;">
              
          </div>
      </div>
  </div>
</div>
<script type="text/javascript">
      $('#showModal').on('show.bs.modal', function (event) {
            $('#showModal .modal-body').html('Loading........');

            var button = $(event.relatedTarget); 
            var recipient = button.data('whatever'); 
            var data_url  = button.data('url'); 
            var modal = $(this);
            console.log(button.className);
            $('#showModal .modal-title').text(recipient);
            $('#showModal .modal-body').load(data_url);
        })

        $('#showModal-xl').on('show.bs.modal', function (event) {
            // $('.navbar-header').removeClass('expanded');
            // $('.main-menu').removeClass('expanded');
            $('#showModal-xl .modal-body').html('Loading........');
            var button = $(event.relatedTarget) 
            var recipient = button.data('whatever') 
            var data_url  = button.data('url') 
            var modal = $(this)
            $('#showModal-xl .modal-title').text(recipient)
            $('#showModal-xl .modal-body').load(data_url);
        })
        

        $('#showModal-sm').on('show.bs.modal', function (event) {
            $('#showModal-sm .modal-body').html('Loading........');

            var button = $(event.relatedTarget) 
            var data_url  = button.data('url') 
            var modal = $(this)
            $('#showModal-sm .modal-body').load(data_url);
        })
</script>
 <input type="hidden" name="tb" value="<?=@$tb_url?>">


    <script type="text/javascript">
jQuery.fn.exists = function(){return this.length>0;}
      

        function loadtb(url=null){
            if (url!=null) {
                var tbUrl = url;
            }
            else
            {
                var tbUrl = $('[name="tb"]').val();
            }
            
            if (tbUrl!='') {
                
                $('#tb').load(tbUrl);
            }
        }
         loadtb();
$(document).on("submit", '.ajaxsubmit', function(event) {
    //alert("Hello");
    event.preventDefault(); 
    $this = $(this);
    if ($this.hasClass("append")) {
        var append_data = $($this.attr('append-data')).val();
        $(this).append('<input type="hidden" name="append" value="'+append_data+'" /> ');

    }
    var form_data = new FormData(this);
    form_valid = true;

    if ($this.hasClass("validate-form")) {
        if ($this.valid()) {
            form_valid = true;
        }
        else{
            form_valid = true;
        }
    }

    setTimeout(function() {
        if (form_valid == true) {
            $.ajax({
                url: $this.attr("action"),
                type: $this.attr("method"),
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    console.log(data);
                    data = JSON.parse(data);
                    if (data.res=='success') {
                        if (!$this.hasClass("load-tb")) {
                            $('#tb').html(data.htmlContent);
                        }
                        if ($this.hasClass("reload-tb")) {
                            loadtb();
                        }
                        if ($this.hasClass("reload-page")) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    }
                    if (data.errors) {
                        $.each(data.errors,function(key,value){
                            $this.find(`[name="${key}"]`).parents(`.form-group`).find(`.error`).text(value);
                        })
                    }
                    alert_toastr(data.res,data.msg);
                    ///loadtb();
                }
                
            })
        }
    }, 100);

    return false;
})
$(document).on('click', '.pag-link', function(event){
            document.body.scrollTop = 0; 
            document.documentElement.scrollTop = 0;
            // var search = $('#tb-search').val();
            var FormData = $('.dynamic-tb-search').serialize();
            $.post($(this).attr('href'),FormData)
            .done(function(data){
                $('#tb').html(data);
            })
            return false;
        })
        $(document).on('change input','.dynamic-tb-search',function(event) {
    $(this).submit();
});

$(document).on('click','.dynamic-tb-search [type=reset]',function(event) {
    $('.dynamic-tb-search')[0].reset();
    setTimeout(function() {
        $('.dynamic-tb-search').submit();
    }, 100);
    
});

$(document).on('submit','.dynamic-tb-search',function(event) {
    $this = $(this);

    $.ajax({
      url: $this.attr("action"),
      type: $this.attr("method"),
      data:  new FormData(this),
      processData: false,
      contentType: false,
      success: function(data){
        // console.log(data);
        // return false;
        // data = JSON.parse(data);
        $($this.attr("tagret-tb")).html(data);
        
        // alert_toastr(data.res,data.msg);
      }
    })
    return false;
})


function alert_toastr(type, message) {
    // Map 'success' to 'success' class, and 'error' to 'error' class
    var toastrClass = (type === 'success') ? 'success' : 'error';

    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 5000, // Time in milliseconds to close the notification automatically
    };

    toastr[toastrClass](message);
}

  function _delete(e){
            
                Swal.fire({
                  toast:true,
                  type: 'warning',
                  title: 'You want to delete ?',
                  timer:3000,
                  showConfirmButton: true,
                  showCancelButton: true,
                  confirmButtonText: `Yes`,
                  cancelButtonText: `No`,
                }).then((result) => {
                    var $this = $(e);
                    url = $this.attr('url');
                    if(result.value==true){
                    $.post(url,function(data){
                        data = JSON.parse(data);
                        if (data.res=='success') {
                            $this.parent().parent().remove();
                        }
                        alert_toastr(data.res,data.msg);
                    })
                    }
                }).catch(swal.noop);
            return false;
          }

        $(document).on('click','[data-toggle="change-status"]', function(event) {
            var t = $(this).parent();
            var data =  $(this).attr('data');
            var value =  $(this).attr('value');
            Swal.fire({
                  toast:true,
                  type: 'warning',
                  title: 'You want to change status ?',
                  timer:3000,
                  showConfirmButton: true,
                  showCancelButton: true,
                  confirmButtonText: `Yes`,
                  cancelButtonText: `No`,
                }).then((result) => {
                    if(result.value==true){

                         $.post('<?=base_url()?>change-status/',{data:data,value:value})
                         .done(function(data){
                                console.log(data);

                                t.html(data);
                            })
                        .fail(function() {
                            alert_toastr("error","error");
                          })
                    }
                }).catch(swal.noop);
            return false;  
        })

    </script>    
</body>

</html>
