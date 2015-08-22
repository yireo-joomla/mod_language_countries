<?php
/**
 * Joomla! module - Language Countries module
 *
 * @author    Yireo (info@yireo.com)
 * @copyright Copyright 2015 Yireo.com. All rights reserved
 * @license   GNU Public License
 * @link      http://www.yireo.com
 */

// Deny direct access
defined('_JEXEC') or die;
?>
	<div id="languagecountries" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<a class="btn btn-default close" data-dismiss="modal" aria-hidden="true">&times;</a>

<<<<<<< HEAD
                    <?php if ($module->showtitle == 1): ?>
					    <h4 class="modal-title"><?php echo $module->title; ?></h4>
                    <?php endif; ?>
=======
					<h4 class="modal-title"><?php echo $module->title; ?></h4>
>>>>>>> 4e680898809fe2d0494573a0ea2f6e94e0d1a34f
				</div>

				<div class="modal-body">
					<?php if (!empty($pretext)): ?>
						<p class="pretext">
							<?php echo $pretext; ?>
						</p>
					<?php endif; ?>

					<?php if (!empty($matchedCountry)) : ?>
						<p class="location">
<<<<<<< HEAD
							<?php echo $helper->_('MOD_LANGUAGE_COUNTRIES_YOUR_LOCATION', $matchedLanguage); ?>
=======
							<?php echo JText::_('MOD_LANGUAGE_COUNTRIES_YOUR_LOCATION'); ?>
>>>>>>> 4e680898809fe2d0494573a0ea2f6e94e0d1a34f
							: <?php echo $matchedCountry; ?>
						</p>
					<?php else: ?>
						<p class="location">
<<<<<<< HEAD
							<?php echo $helper->_('MOD_LANGUAGE_COUNTRIES_UNKNOWN_LOCATION', $matchedLanguage); ?>
=======
							<?php echo JText::_('MOD_LANGUAGE_COUNTRIES_UNKNOWN_LOCATION'); ?>
>>>>>>> 4e680898809fe2d0494573a0ea2f6e94e0d1a34f
						</p>
					<?php endif; ?>

					<div class="row">
						<?php foreach ($languages as $language) : ?>
<<<<<<< HEAD
							<?php $class = array('span3', 'language-choice'); ?>
							<?php
=======
							<?php
                            $class = array('span3', 'language-choice');

					        if ($hideOthers && $language->match == false && $language->current == false)
					        {
						        continue;
					        }

>>>>>>> 4e680898809fe2d0494573a0ea2f6e94e0d1a34f
							if ($language->match)
							{
								$class[] = 'match';
							}
<<<<<<< HEAD
							?>
							<?php
=======

>>>>>>> 4e680898809fe2d0494573a0ea2f6e94e0d1a34f
							if ($language->current)
							{
								$class[] = 'current';
							}
							?>
							<div class="<?php echo implode(' ', $class); ?>">

<<<<<<< HEAD
								<h3><?php echo $language->image; ?> <?php echo $language->title; ?></h3>

								<p>
                                    <?php if ($language->current) : ?>
                                    <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">
                                        <?php echo $helper->_('MOD_LANGUAGE_COUNTRIES_CONTINUE', $language); ?>
                                    </a>
                                    <?php else: ?>
                                    <a href="<?php echo $language->link; ?>" class="btn">
                                        <?php echo $helper->_('MOD_LANGUAGE_COUNTRIES_CONTINUE', $language); ?>
                                    </a>
                                    <?php endif; ?>
								</p>

=======
								<h3><?php echo $language->image; ?> <?php echo $language->title_native; ?></h3>

								<p>
									<a href="<?php echo $language->link; ?>" class="btn">
										<?php echo JText::_('MOD_LANGUAGE_COUNTRIES_CONTINUE'); ?>
									</a>
								</p>

                                <?php if ($showCountries) : ?>
>>>>>>> 4e680898809fe2d0494573a0ea2f6e94e0d1a34f
								<ul class="countries">
									<?php foreach ($language->countries as $country): ?>
										<li><?php echo $country->label; ?></li>
									<?php endforeach; ?>
								</ul>
<<<<<<< HEAD
=======
                                <?php endif; ?>
>>>>>>> 4e680898809fe2d0494573a0ea2f6e94e0d1a34f
							</div>
						<?php endforeach; ?>
					</div>

					<?php if ($redirect && $matchedLanguageName) : ?>
						<div class="redirect">
<<<<<<< HEAD
							<?php echo $helper->sprintf('MOD_LANGUAGE_COUNTRIES_COUNTDOWN_MESSAGE', $matchedLanguage, $matchedLanguageName); ?>
							<span class="countdown-timer"><?php echo $redirectTime; ?></span>
							<?php echo $helper->_('MOD_LANGUAGE_COUNTRIES_COUNTDOWN_SECONDS', $matchedLanguage); ?>
=======
							<?php echo JText::sprintf('MOD_LANGUAGE_COUNTRIES_COUNTDOWN_MESSAGE', $matchedLanguageName); ?>
							<span class="countdown-timer"><?php echo $redirectTime; ?></span>
							<?php echo JText::_('MOD_LANGUAGE_COUNTRIES_COUNTDOWN_SECONDS'); ?>
>>>>>>> 4e680898809fe2d0494573a0ea2f6e94e0d1a34f
						</div>
					<?php endif; ?>
				</div>

				<div class="modal-footer">
					<a href="#" class="btn btn-default" data-dismiss="modal"
<<<<<<< HEAD
					   aria-hidden="true"><?php echo $helper->_('MOD_LANGUAGE_COUNTRIES_MODAL_CLOSE', $matchedLanguage); ?></a>
=======
					   aria-hidden="true"><?php echo JText::_('MOD_LANGUAGE_COUNTRIES_MODAL_CLOSE'); ?></a>
>>>>>>> 4e680898809fe2d0494573a0ea2f6e94e0d1a34f
				</div>
			</div>
		</div>
	</div>

	<script>
		var languageCountriesDisableAutoRedirect = <?php echo (int) $isMatchedLanguageCurrent; ?>;
		var languageCountriesRedirectTime = <?php echo (int) $redirectTime ?>;
		var languageCountriesMatchedLanguageLink = '<?php echo $matchedLanguageLink ?>';
	</script>

<?php if ($showModal == true): ?>
	<script>
		jQuery(document).ready(function () {
			showLanguageCountriesModal();
		});
	</script>
<?php endif; ?>

<?php if ($showButton == true): ?>
	<div id="languagecountries-button">
<<<<<<< HEAD
		<a href="#" class="btn btn-default"><?php echo $helper->_('MOD_LANGUAGE_COUNTRIES_SHOW_MODAL', $matchedLanguage); ?></a>
=======
		<a href="#" class="btn btn-default"><?php echo JText::_('MOD_LANGUAGE_COUNTRIES_SHOW_MODAL'); ?></a>
>>>>>>> 4e680898809fe2d0494573a0ea2f6e94e0d1a34f
	</div>
<?php endif; ?>
