    <div id="content" class="narrowcolumn">
        <div id="content_middle">
            <div class="accordion">
                <h2 class="headerstyle">
                    <img src="assets/images/64px-Application-certificate.svg.png" style="vertical-align:middle" alt="installstep image" />
                    <?php echo $language['STEP3_LICENSE']; ?>
                </h2>
                <p><?php echo $language['STEP3_SENTENCE1']; ?></p>
                <p><?php echo $language['STEP3_REVIEW_THIRDPARTY']; ?></p>
                <p><?php echo $language['STEP3_REVIEW_CLANSUITE']; ?></p>
                <!-- IFRAME WITH LICENSE -->
                <?php
                    $language_file = 'Languages/'.$_SESSION['lang'].'.gpl.html';
                    $language_file = is_file($language_file) ? $language_file : 'Languages/english.gpl.html';
                ?>
                <iframe scrolling="auto" frameborder="0" marginwidth="15" class="license" src="<?php echo $language_file; ?>"></iframe>
                <!-- CHECKBOX -> READ LICENSE -->
                <div class="">
                    <p><?php echo $language['STEP3_MUST_AGREE']; ?></p>
                    <label for="agreecheck">
                        <input type="checkbox" class="inputbox" id="agreecheck" name="agreecheck"
                           onclick="var buttonNext = document.getElementById('ButtonNext');
                                    if (this.checked==true) { buttonNext.disabled=false; buttonNext.className='ButtonGreen';
                                    } else { buttonNext.disabled=true; buttonNext.className='ButtonGrey'; }" />
                        <?php echo $language['STEP3_CHECKBOX']; ?>
                    </label>
                </div>
                <div id="content_footer">
                    <div class="navigation">
                        <span class="font-10">
                            <?php echo $language['CLICK_NEXT_TO_PROCEED']; ?>
                            <br />
                            <?php echo $language['CLICK_BACK_TO_RETURN']; ?>
                        </span>
                        <form action="index.php" method="post">
                            <div class="alignleft">
                                <input type="submit" value="<?php echo $language['BACKSTEP']; ?>" class="ButtonRed" name="step_backward" />
                                <input type="hidden" name="lang" value="<?php echo $_SESSION['lang']; ?>" />
                            </div>
                            <div class="alignright">
                                <input type="submit" value="<?php echo $language['NEXTSTEP']; ?>" class="ButtonGrey" name="step_forward" id="ButtonNext" disabled="disabled" />
                                <input type="hidden" name="lang" value="<?php echo $_SESSION['lang']; ?>" />
                                <input type="hidden" name="submitted_step" value="3" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
