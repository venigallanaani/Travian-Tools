<?php
function displayWheatScoutCalculator(){
?>
	<div id="contentRegular">
		<p class="header">Wheat Scout Calculator</p>
		<form action="calculators.php?calc=ws" method="post">
			<table style="width:60%; margin:auto;">
				<tr>
					<th>First Report:</th>
					<th>Village Details:</th>
					<th>Second Report:</th>					
				</tr>
				<tr>
					<td><textarea rows="5" cols="25" name="scoutStr1" required></textarea></td>					
					<td><p>Crop Tiles:
							<select name="cropper">
								<option value='15'>15c</option>
								<option value='9'>9c</option>
								<option value='7'>7c</option>
								<option value='6'>6c</option>
							</select>
						</p>
						<p>Tiles Level:
							<select name="lvl">
								<option value='7'>1</option><option value='13'>2</option><option value='21'>3</option><option value='31'>4</option>
								<option value='46'>5</option><option value='70'>6</option><option value='98'>7</option><option value='140'>8</option>
								<option value='203'>9</option><option value='280'>10</option><option value='392'>11</option><option value='525'>12</option>
								<option value='693'>13</option><option value='889'>14</option><option value='1120'>15</option><option value='1400'>16</option>
								<option value='1820'>17</option><option value='2240'>18</option><option value='2800'>19</option><option value='3430'>20</option>
								<option value='4270'>21</option>
							</select>						
						</p>
						<p>Crop Oasis:
							<select name="oasis">
								<option value='0'>0%</option>
								<option value='25'>25%</option>
								<option value='50'>50%</option>
								<option value='75'>75%</option>
								<option value='100'>100%</option>
								<option value='125'>125%</option>
								<option value='150'>150%</option>
							</select>
						</p>
					</td>
					<td><textarea rows="5" cols="25" name="scoutStr2" required></textarea></td>
				</tr>
				<tr>
					<td colspan="3" style="text-align:center;padding:10px 0px;"><button class="button" name="wheatScout">Calculate</button></td>
				</tr>
			</table>		
		</form>		
	</div>
<?php
// Calculate the wheat calculator details 
    if(isset($_POST['wheatScout'])){
        $sctRpt1[]=parseScoutReport($_POST['scoutStr1']);
        $sctRpt2[]=parseScoutReport($_POST['scoutStr2']);
?>
	<div id="contentRegular">
		<p style="color:red;">To Be Developed</p>	
	</div>
<?php 
    }
}
?>

<?php 
function parseScoutReport($sctStr){
//=====================================================================================================
//                  Pasrses the string and gives the array of the results
//=====================================================================================================
    $parseStrings = preg_split('/$\R?^/m', $sctStr); 
    
    
    
    
}

?>


