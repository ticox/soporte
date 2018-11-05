 <!--==========================
    New Footer - Nuevo Pie de pagina
  ============================-->
</div>
<script src="<?php echo BASE_URL; ?>public/js/modalEffects.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>public/js/classie.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>public/js/modernizr.custom.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>public/js/cssParser.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>public/js/alertify.min.js" type="text/javascript"></script>
  <script src="<?php echo BASE_URL; ?>public/js/jquery.js" type="text/javascript"></script>
  <script src="<?php echo BASE_URL; ?>public/js/config.js" type="text/javascript"></script>
  <script src="<?php echo BASE_URL; ?>public/js/bootstrap.min.js"></script>
 <script src="<?php echo BASE_URL; ?>public/js/ripples.min.js"></script>
  <script src="<?php echo BASE_URL; ?>public/js/material.min.js"></script>
  <script src="<?php echo BASE_URL; ?>public/js/jquery-3.1.1.min.js"></script>
<!--   <script src="<?php echo BASE_URL; ?>public/js/sweetalert2.min.js"></script> -->
  <script src="<?php echo BASE_URL; ?>public/js/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?php echo BASE_URL; ?>public/js/main.js"></script>
  <script src="<?php echo BASE_URL; ?>public/js/jquery.magnifier.js"></script>
  
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

<?php if(isset($_layoutParams['js']) && count($_layoutParams['js'])): ?>
    <?php for($i=0; $i < count($_layoutParams['js']); $i++): ?>
        <script src="<?php echo $_layoutParams['js'][$i] ?>" type="text/javascript"></script>
    <?php endfor; ?>
<?php endif; ?>


</body>
</html>