let navLinks = document.querySelector('.navLinks');
			let header = document.getElementById("nav-box");
			function showMenu(){
				navLinks.style.right = "0";
			}

			function hideMenu(){
				navLinks.style.right = "-200px";
			}
			window.onscroll = function() {myFunction()};

			// Get the header


			function myFunction() {
				if (window.pageYOffset > 0) {
					header.classList.add("solid");
				} else {
					header.classList.remove("solid");
				}
			}
