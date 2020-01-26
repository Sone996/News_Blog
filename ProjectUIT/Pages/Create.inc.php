<!--konekcija-->
<?php
$conn = mysqli_connect("localhost", "root", "", "uit");
if (mysqli_connect_errno()) {
    die("Neuspela konekcija sa bazom <br>Poruka o gresci:" . mysqli_connect_error());
}
mysqli_close($conn);
?>
<?php if(!isset($_SESSION['Username'])) : ?>
        <link rel="stylesheet" type="text/css" href="../CSS/Create.css">
    <body>
        <div>
            <h1>Create an account</h1>
            <form style="line-height: 250%" method="post">
                <table>
                    <tr><td class="L"> <span>Name:</span></td>
                        <td class="R"><input type="text" name="name"  placeholder="name"><br></td></tr>
                    <tr><td class="L"><span>Last name:</span></td>
                        <td class="R"><input  type="text" name="last_name"  placeholder="last name"><br></td></tr> 
                    <tr><td class="L"> <span>E-mail:</span></td>
                        <td class="R"> <input type="text" name="mail" placeholder="mail"><br></td></tr>
                    <tr><td class="L"> <span>User name:</span></td>
                        <td class="R"><input type="text" name="user" placeholder="username"><br></td></tr> 
                    <tr><td class="L"> <span>Password:</span></td>
                        <td class="R"> <input  type="password" name="password" ><br></td></tr>
                </table>
                <input id="dugme" type="Submit" name="Registrate" value="Registrate">
            </form>
        </div>
<?php endif; ?>
<?php if(isset($_SESSION['Username'])) : ?>
        <h3>You are already logged in.</h3>
<?php endif; ?>