		</div>

		<script>
			$(document).ready(function() {
				
				const limitTime = new Date();
				limitTime.setHours(22);
				limitTime.setMinutes(30);
				limitTime.setSeconds(0);

				const today_start = new Date();
				today_start.setHours(0);
				today_start.setMinutes(0);
				today_start.setSeconds(0);
				today_start.setMilliseconds(0);	

				const last_report_day = new Date($("#report-day").val());
				
				var timer = setInterval(function(){
					
					const now = new Date();

					if((limitTime.getTime() < now.getTime()) &&  (last_report_day.getTime() - today_start.getTime() < 0))
					{
						clearInterval(timer);
						$(".alertbar").addClass("alertbar-transition-active");
					}

				},1000);
			});
		</script>
	</body>
</html>