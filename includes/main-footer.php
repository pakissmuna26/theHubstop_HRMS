<div class="bs-toast toast toast-placement-ex m-2 fade top-0 end-0 divToast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
  <div class="toast-header">
    <i class="bx bx-bell me-2"></i>
    <div class="me-auto fw-semibold toast_header"></div>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body toast_message"></div>
</div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <script type="text/javascript" src="assets/datatables_bootstrap4/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="assets/datatables_bootstrap4/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="assets/datatables_bootstrap4/dataTables.bootstrap4.min.js"></script>


    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/js/ui-popover.js"></script>
    <!-- <script src="assets/js/dashboards-analytics.js"></script> -->
    <!-- <script src="assets/js/ui-modals.js"></script> -->
    <script type="text/javascript">
        function ToggleDIV(id,status){
            document.getElementById(id).style.display=status;
        }
      // Bootstrap toasts example
      // --------------------------------------------------------------------
      const toastPlacementExample = document.querySelector('.toast-placement-ex');
      let selectedType, selectedPlacement, toastPlacement;

      // Dispose toast when open another
      function toastDispose(toast) {
        if (toast && toast._element !== null) {
          if (toastPlacementExample) {
            toastPlacementExample.classList.remove(selectedType);
            DOMTokenList.prototype.remove.apply(toastPlacementExample.classList, selectedPlacement);
          }
          toast.dispose();
        }
      }

      // selectTypeOpt: bg-primary, bg-secondary, bg-success, bg-danger, bg-warning, bg-info, bg-dark
      function ShowToast(selectTypeOpt, header, message){
        $(".toast_header").text(header);
        $(".toast_message").text(message);
        let selectPlacement = "top-0 end-0";
        if (toastPlacement) {
          toastDispose(toastPlacement);
        }
        selectedType = selectTypeOpt;
        selectedPlacement = selectPlacement.split(' ');
        toastPlacementExample.classList.add(selectedType);
        DOMTokenList.prototype.add.apply(toastPlacementExample.classList, selectedPlacement);
        toastPlacement = new bootstrap.Toast(toastPlacementExample);
        toastPlacement.show();
      }
    </script>
    <!-- <script src="assets/js/ui-toasts.js"></script> -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <!-- <script async defer src="https://buttons.github.io/buttons.js"></script> -->
  </body>
</html>
