<?php

namespace Drupal\language_switcher_popup\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure Language Switcher Popup settings.
 */
class LanguageSwitcherPopupSettingsForm extends ConfigFormBase {

  /**
   * The language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * Constructs a LanguageSwitcherPopupSettingsForm object.
   *
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   */
  public function __construct(LanguageManagerInterface $language_manager) {
    $this->languageManager = $language_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get("language_manager")
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ["language_switcher_popup.settings"];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return "language_switcher_popup_settings";
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config("language_switcher_popup.settings");
    $languages = $this->languageManager->getLanguages();

    $form["description"] = [
      "#markup" => "<p>" . $this->t("Configure the popup messages when users switch languages. The popup will only appear when search parameters are present.") . "</p>",
    ];

    $form["enable_popup"] = [
      "#type" => "checkbox",
      "#title" => $this->t("Enable Popup"),
      "#default_value" => $config->get("enable_popup") ?? TRUE,
    ];

    foreach ($languages as $langcode => $language) {
      $form[$langcode] = [
        "#type" => "details",
        "#title" => $language->getName() . " (" . $langcode . ")",
        "#open" => FALSE,
      ];

      $form[$langcode]["message_{$langcode}"] = [
        "#type" => "textarea",
        "#title" => $this->t("Popup Message"),
        "#default_value" => $config->get("message_{$langcode}") ?: $this->t("Switching languages will reset your search filters. Do you want to continue?"),
        "#rows" => 3,
      ];

      $form[$langcode]["confirm_{$langcode}"] = [
        "#type" => "textfield",
        "#title" => $this->t("Confirm Button Text"),
        "#default_value" => $config->get("confirm_{$langcode}") ?: $this->t("Continue"),
        "#required" => TRUE,
      ];

      $form[$langcode]["cancel_{$langcode}"] = [
        "#type" => "textfield",
        "#title" => $this->t("Cancel Button Text"),
        "#default_value" => $config->get("cancel_{$langcode}") ?: $this->t("Cancel"),
        "#required" => TRUE,
      ];
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config("language_switcher_popup.settings");
    $languages = $this->languageManager->getLanguages();

    $config->set("enable_popup", $form_state->getValue("enable_popup"));

    foreach ($languages as $langcode => $language) {
      $config->set("message_{$langcode}", $form_state->getValue("message_{$langcode}"));
      $config->set("confirm_{$langcode}", $form_state->getValue("confirm_{$langcode}"));
      $config->set("cancel_{$langcode}", $form_state->getValue("cancel_{$langcode}"));
    }

    $config->save();

    parent::submitForm($form, $form_state);
  }

}
