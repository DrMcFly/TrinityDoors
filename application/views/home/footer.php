
	
		<!-- Chat -->
		<style>
				
				/* Button used to open the chat form - fixed at the bottom of the page */
				.open-button {
				background-color: #555;
				color: white;
				padding: 16px 20px;
				border: none;
				cursor: pointer;
				opacity: 0.8;
				position: fixed;
				bottom: 23px;
				right: 28px;
				width: 280px;
				}

				/* The popup chat - hidden by default */
				.chat-popup {
				display: none;
				position: fixed;
				bottom: 0;
				right: 15px;
				border: 3px solid #f1f1f1;
				z-index: 9;
				}

				/* Add styles to the form container */
				.form-container {
				max-width: 300px;
				padding: 10px;
				background-color: white;
				}

				/* Full-width textarea */
				.form-container textarea {
				width: 100%;
				padding: 15px;
				margin: 5px 0 22px 0;
				border: none;
				background: #f1f1f1;
				resize: none;
				min-height: 200px;
				}

				/* When the textarea gets focus, do something */
				.form-container textarea:focus {
				background-color: #ddd;
				outline: none;
				}

				/* Set a style for the submit/send button */
				.form-container .btn {
				background-color: #04AA6D;
				color: white;
				padding: 16px 20px;
				border: none;
				cursor: pointer;
				width: 100%;
				margin-bottom:10px;
				opacity: 0.8;
				}

				/* Add a red background color to the cancel button */
				.form-container .cancel {
				background-color: red;
				}

				/* Add some hover effects to buttons */
				.form-container .btn:hover, .open-button:hover {
				opacity: 1;
				}
			</style>		
			<button class="open-button" onclick="openForm(); getPage('chat','ai/hello','chat-ai');">Chat</button>

			<div class="chat-popup" id="myForm">
				<form id="sendForm" action="/chat/send" method="post" class="form-container">
					<h1>Chat</h1>
					<div class="page-content message-content">
						<div class="textarea" id="chat-ai"> 

						</div>  
						<div class="textarea" id="chat-me"> 

						</div>
					</div>
					<div class="form-field col-sm-12">
						<label for="msg"><b>Message</b></label>
						<input type="text" id="message" name="message">
					</div>
					<button type="button" class="btn" onclick="postForm('sendForm','chat-me');">Send</button>
					<button type="button" class="btn cancel" onclick="closeForm()">Close</button>
				</form>
			</div>

			<script>
			function openForm() {
			document.getElementById("myForm").style.display = "block";
			}

			function closeForm() {
			document.getElementById("myForm").style.display = "none";
			}
			</script>

	<!--/chat -->
	
	
	<!-- Begin Footer -->
	<footer>
		<div class="container">
			<div class="row">

				<!-- Contact List -->
				<ul class="contact-list col-md-8">
					<!--<li><i class="fa fa-envelope-o"></i><a href="mailto:hello@form.com">hello@form.com</a></li>-->
					<li><i class="fa fa-phone"></i><a href="#">+ 501-402-0812</a></li>
					<li><i class="fa fa-map-marker"></i><a href="https://duckduckgo.com/?q=4+leisure+valley+drive+conway+ar+72034&ia=web&iaxm=maps" target="_blank">4 Leisure Valley Dr. Conway AR 72032</a></li>
				</ul><!-- END -->

				<!-- Social List -->
				<ul class="social-list col-md-4">
					<li><a href="https://www.facebook.com/trinitydoors.us" target="_blank"><i class="fa fa-facebook"></i></a></li>
				<!--	<li><a href="#"><i class="fa fa-twitter"></i></a></li>
					<li><a href="#"><i class="fa fa-instagram"></i></a></li>
					<li><a href="#"><i class="fa fa-pinterest"></i></a></li>-->
					<li class="copyright">© <?=date("Y")?> TrinityDoors, LLC</li>
				</ul><!-- END -->

			</div>
		</div>
	</footer>
	<!-- End Footer -->
	

	<!-- Javascript -->
	<script src="/js/retina.js"></script>
	<script src="/js/backgroundcheck.js"></script>
	<script src="/js/plugins.js"></script>

	<script src="/js/main.js"></script>
</body>

</html>