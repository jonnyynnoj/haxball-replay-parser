<html>
	<head>
		<title>Haxball Replay Dumper</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	
	<body>
	
		<div style="float: right; margin: 0px 10px; text-align: justify; width: 50%;">
			
			<span style="float: right">
				<a href="https://github.com/jonnyynnoj/haxball-replay-parser">View Source on Github</a>
			</span>
			
			<span style="font-weight: bold">What is this?</span>
			
			<p>
				This application originally started out as a small project to see how easy it is to read haxball's replay files and what could be
				done with that information. The result is that you get a load of mostly pointless information back, although the kick times could possibly be used to prove someone is macroing.
			</p>
			
			<span style="font-weight: bold">Why do a lot of the times end with 667 or 333?</span>
			
			<p>
				The replays are simply a list of actions within a frame. There are 60 frames per second which means each frame happens at 0.016666667 of a second. Multiplying this doesn't give you nice decimals very often.
			</p>
			
			<span style="font-weight: bold">What do the kick times show?</span>
			
			<p>
				The kick times show the difference between each player's kick, that's it; on their own they won't prove anything. The idea of the times though is that you'd then go and watch the replay and map the kick times to the different points in the match, which will give a much better picture of what is going on. Going even further you'd watch the rest of the match and even other matches where the player is in a similar situation (corner lift, double bounce, etc) and gather the corresponding kick times for those situations.<br />
				The end result of this could be that you have lots of situations of suspected macroing and the corresponding kick times show very similar or even identical patterns, which would provide strong evidence of a macro being used.
			</p>
			
			<span style="font-weight: bold">It's all about gathering lots of data</span>
			
			<p>
				Small patterns of data don't prove anything; it's very easy for someone who isn't macroing to produce (for example) a series of 4 kicks all spaced 0.06667 apart.<br />
				Similarily, you don't need a macro to kick at the fastest time of 0.016667
			</p>
			
			<span style="font-weight: bold">Anything else?</span>
			
			<p>
				I made a Google Chrome room list extension,
				<a href="https://chrome.google.com/webstore/detail/opjadepcdiciepdplcnfcoldbpbjogdn">try it out</a> :)
				<br /><br />
				
				<img src="http://i.imgur.com/UPGvj.png" />
			</p>
		
		</div>
		
		<div>
			Select Haxball Replay File:
			
			<form method="post" enctype="multipart/form-data">
			
				<input type="file" name="replay" /><br /><br />
				
				Or enter haxballtube URL:<br />
				<input type="text" name="haxballtubelink" size="50" /><br /><br />
				
				Room Info (&amp; starting stadium): <input type="checkbox" name="roominfo" value="1" checked="checked" /><br />
				Show Discs: <input type="checkbox" name="showdiscs" value="1" /><br />
				List Start Players: <input type="checkbox" name="showplayers" value="1" checked /><br />
				Show Custom Stadiums: <input type="checkbox" name="showstadiums" value="1" checked /><br />
				Show Kicks: <input type="checkbox" name="showkicks" value="1" /><br />
				Show All Actions: <input type="checkbox" name="showactions" value="1" /> (<span style="color: red">may crash browser on large replay files</span>)<br /><br />
				<input type="submit" />
				
			</form>
		</div>
		
		<div><?php if ($_SERVER['REQUEST_METHOD'] == 'POST') include 'showresults.php'; ?></div>
	</body>
</html>