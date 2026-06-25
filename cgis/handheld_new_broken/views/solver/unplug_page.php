<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Solver BOS</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/bulma/css/main.css">
    </head>
    <body>
        <nav class="navbar is-transparent">
            <div class="navbar-brand">
                <a class="navbar-item" href="<?php echo base_url();?>handheld.php/solverhandheld">
                    <img
                        src="https://bulma.io/images/bulma-logo.png"
                        alt="Bulma: a modern CSS framework based on Flexbox"
                        width="112"
                        height="28">
                </a>
                <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div id="navbarExampleTransparentExample" class="navbar-menu">
                <div class="navbar-start">
                    <a
                        class="navbar-item"
                        href="<?php echo base_url();?>handheld.php/solverhandheld/signout">
                        SignOut
                    </a>
                </div>
            </div>
        </nav>
        <section class="section">
            <div class="container">
                <h1 class="title">
                    UNPLUG
                </h1>
                <div class="columns is-mobile">
                    <div class="column">
                        <div class="field is-grouped">
                            <p class="control is-expanded">
                                <input class="input" type="text" placeholder="kontainer">
                            </p>
                            <p class="control">
                                <a class="button is-info">
                                    Search
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="columns is-mobile">
                    <div class="column">
                        <div class="table-container">
                            <table class="table is-bordered">
                                <tr>
                                    <th>1</th>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>2</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script type="text/javascript" src="echo base_url();?>assets/bulma/lib/main.js"></script>
    </body>
</html>