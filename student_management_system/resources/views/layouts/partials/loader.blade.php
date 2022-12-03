
{{-- <div id="loader" class="container-fluid justify-content-center" style="height: 100vh;
width: 100vw;
background: rgba(255, 255, 255, 1);
z-index: 10000;
position: fixed;">
    <img src="{{ asset('assets/img/loader2.gif') }}" style="margin: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);">
</div> --}}
<style>
    .loader {
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #8e24aa;
      width: 120px;
      height: 120px;
      -webkit-animation: spin 2s linear infinite; /* Safari */
      animation: spin 2s linear infinite;
      position: absolute;
      left: calc(50% - 60px);
      top: calc(50% - 60px);
      z-index: 2001;
    }
    #loader{
        width: 100vw;
        height: 100vh;
        background-color: white;
        z-index: 2000;
        position: fixed;
    }
    
    /* Safari */
    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
</style>

<div id="loader"><div class="loader"></div></div>