	</div>
	<script type="text/javascript">
		
		$('.status-msg-close-icon i').on('click',function(event){
			
			$('.status-msg-block').animate({ opacity:'0' }, 500,"swing",function(){
				
				$('.status-msg-block').animate({ height:'0px'},500,"swing")

				$('.status-msg-block').css({
					display:'none'
				})
			})
		})
	</script>
</body>
</html>