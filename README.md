# Language Switcher Popup

Shows a confirmation popup that search filters will be reset when users switch languages.

The popup automatically appears when:
- User switches language using language switcher block
- Search parameters are present in the URL (e.g., `?search=keyword`)

## Usage

1. Have multiple languages enabled
2. Download and enable module
3. Go to configuration (e.g. /admin/config/regional/language-switcher-popup) to customize popup
4. Search something
5. Click on a lanugage switcher link and popup will appear


## Configuration

- Disable/Enable popup
- Popup message and button text for each language

## Folder Structure

```
language_switcher_popup/
├── css/
│   └── language_switcher_popup.css       # Popup styling
├── js/
│   └── language_switcher_popup.js        # Popup behavior
├── src/
│   └── Form/
│       └── LanguageSwitcherPopupSettingsForm.php  # Configuration form
├── composer.json                         
├── language_switcher_popup.info.yml      
├── language_switcher_popup.libraries.yml # 
├── language_switcher_popup.links.menu.yml 
├── language_switcher_popup.module        
├── language_switcher_popup.routing.yml   
└── README.md                           
```
