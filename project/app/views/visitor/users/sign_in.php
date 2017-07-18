<div class="row vertical align">

    <?php // l,large:desktop m,medium:tablet s,small:mobile ?>
    <div class="col l4 m8 s12 offset-l4 offset-m2">

        <h2 class="indigo-text darken-2 center-align">
            <b>Encoder</b> <span class="grey-text">PHP</span>
        </h2>

        <div class="white" style="padding: 30px; border-radius: 5px;">
            <?php
            echo partial('blocks/sign_in', array(
                'user' => $user
            ));
            ?>
        </div>

        <br/>
        <hr/>
        
        <div class="centered center-align large-text-8 tnr">
            <div class="blue-text text-darken-2 tnr">
                user@encoder.com
            </div>
            
            12345
        </div>
    </div>

</div>