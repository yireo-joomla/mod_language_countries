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

					<h4 class="modal-title"><?php echo $module->title; ?></h4>
				</div>

				<div class="modal-body">
					<?php if (!empty($pretext)): ?>
						<p class="pretext">
							<?php echo $pretext; ?>
						</p>
					<?php endif; ?>

					<?php if (!empty($matchedCountry)) : ?>
						<p class="location">
							<?php echo JText::_('MOD_LANGUAGE_COUNTRIES_YOUR_LOCATION'); ?>
							: <?php echo $matchedCountry; ?>
						</p>
					<?php else: ?>
						<p class="location">
							<?php echo JText::_('MOD_LANGUAGE_COUNTRIES_UNKNOWN_LOCATION'); ?>
						</p>
					<?php endif; ?>

					<div class="row">
						<?php foreach ($languages as $language) : ?>
							<?php
                            $class = array('span3', 'language-choice');

					        if ($hideOthers && $language->match == false && $language->current == false)
					        {
						        continue;
					        }

							if ($language->match)
							{
								$class[] = 'match';
							}

							if ($language->current)
							{
								$class[] = 'current';
							}
							?>
							<div class="<?php echo implode(' ', $class); ?>">

								<h3><?php echo $language->image; ?> <?php echo $language->title_native; ?></h3>

								<p>
									<a href="<?php echo $language->link; ?>" class="btn">
										<?php echo JText::_('MOD_LANGUAGE_COUNTRIES_CONTINUE'); ?>
									</a>
								</p>

                                <?php if ($showCountries) : ?>
								<ul class="countries">
									<?php foreach ($language->countries as $country): ?>
										<li><?php echo $country->label; ?></li>
									<?php endforeach; ?>
								</ul>
                                <?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>

					<?php if ($redirect && $matchedLanguageName) : ?>
						<div class="redirect">
							<?php echo JText::sprintf('MOD_LANGUAGE_COUNTRIES_COUNTDOWN_MESSAGE', $matchedLanguageName); ?>
							<span class="countdown-timer"><?php echo $redirectTime; ?></span>
							<?php echo JText::_('MOD_LANGUAGE_COUNTRIES_COUNTDOWN_SECONDS'); ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="modal-footer">
					<a href="#" class="btn btn-default" data-dismiss="modal"
					   aria-hidden="true"><?php echo JText::_('MOD_LANGUAGE_COUNTRIES_MODAL_CLOSE'); ?></a>
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
		<a href="#" class="btn btn-default"><?php echo JText::_('MOD_LANGUAGE_COUNTRIES_SHOW_MODAL'); ?></a>
	</div>
<?php endif; ?>
