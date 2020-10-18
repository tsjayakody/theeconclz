<style>
	canvas {
		display: block;
	}

	/* ---- particles.js container ---- */
	#particles-js {
		width: 100%;
		height: 100%;
		background-color: #b6192300;
		background-image: url("");
		background-repeat: no-repeat;
	}

	.logoimage {
		position: absolute;
		align-items: center;
		align-self: center;
		align-content: center;
		text-align: center;
		z-index: -1;
	}

    .welcomemsg{
        font-size: 4em !important;
    }
</style>

<div class="content">
	<div class="container-fluid">
		<div class="col-md-12 logoimage">
			<img src="assets/img/logo.png" alt="img logo background" />
            <div class="col-md-12" style="font-size: 3em;">Welcome to LMS management panel.</div>
            <div id="txt" style="font-size: 4em; margin-top: 40px;"></div>
			<div class="col-md-12"></div>
		</div>
		<!-- particles.js container -->
		<div id="particles-js"></div>
		<script src="assets/js/particles/particles.js"></script>
	</div>
</div>
<script>
  /*  startTime();
	particlesJS("particles-js", {
		particles: {
			number: { value: 80, density: { enable: true, value_area: 800 } },
			color: { value: "#BFBFBF" },
			shape: {
				type: "circle",
				stroke: { width: 0, color: "#000000" },
				polygon: { nb_sides: 5 },
				image: { src: "img/github.svg", width: 100, height: 100 }
			},
			opacity: {
				value: 0.5,
				random: false,
				anim: { enable: false, speed: 1, opacity_min: 0.1, sync: false }
			},
			size: {
				value: 3,
				random: true,
				anim: { enable: false, speed: 40, size_min: 0.1, sync: false }
			},
			line_linked: {
				enable: true,
				distance: 150,
				color: "#BFBFBF",
				opacity: 0.6,
				width: 1
			},
			move: {
				enable: true,
				speed: 6,
				direction: "none",
				random: false,
				straight: false,
				out_mode: "out",
				bounce: false,
				attract: { enable: false, rotateX: 600, rotateY: 1200 }
			}
		},
		interactivity: {
			detect_on: "canvas",
			events: {
				onhover: { enable: true, mode: "bubble" },
				onclick: { enable: true, mode: "push" },
				resize: true
			},
			modes: {
				grab: { distance: 400, line_linked: { opacity: 1 } },
				bubble: { distance: 400, size: 30, duration: 2, opacity: 1, speed: 3 },
				repulse: { distance: 200, duration: 0.4 },
				push: { particles_nb: 4 },
				remove: { particles_nb: 2 }
			}
		},
		retina_detect: true
	});

	function startTime() {
		var today = new Date();
		var h = today.getHours();
		var m = today.getMinutes();
		var s = today.getSeconds();
		m = checkTime(m);
		s = checkTime(s);
		document.getElementById("txt").innerHTML = h + ":" + m + ":" + s;
		var t = setTimeout(startTime, 500);
	}
	function checkTime(i) {
		if (i < 10) {
			i = "0" + i;
		} // add zero in front of numbers < 10
		return i;
	}*/
</script>
