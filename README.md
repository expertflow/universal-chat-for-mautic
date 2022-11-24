# Universal chat for Mautic 3.x
Universal chat for Mautic Webchat, SMS, Whatsapp, Facebook Messenger, LiveChat, and plugin to any chatbot (Rasa, Google Dialogflow, IBM Watson,...). 

## Requirements
1. Mautic 3.2
2. PHP 7+
3. Stomp-php 5.0.0 (https://github.com/stomp-php/stomp-php)
4. https://github.com/expertflow/universal-chat-for-mautic


## How to install

### Prerequisites

1. Go to the **Vendor** folder in the Mautic server directory using sftp access (html/vendor/)
2. Create a new folder named `stomp-php`
3. Download Stomp-php release 5.0.0 from (https://github.com/stomp-php/stomp-php)
4. Extract it to vendor/stomp-php/ folder.
5. Run `rm -rf var/cache/*` 


### Plugin Installation (do not use composer at this time)

1. Download https://github.com/expertflow/mautic-amq-plugin
2. Extract it to `plugins/MauticActivemqTransportBundle`
3. Delete `app/cache/prod` or run `rm -rf var/cache/*` to clear the cache 
4. Go to `Plugins` in the Mautic admin menu (/s/plugins)
5. Click on the `Install / Upgrade Plugin` button to install plugin or run `php app/console mautic:plugins:install` to install plugin via commandline
6. Go to Mautic configuration (/s/config/edit) and click on the **Text Message Settings**, then choose **ActiveMQ** as the default transport.


## Send Test Text Message

### Setup Campaign to Send Text Message via ActiveMQ

After configure the plugin.

1. Go to `Channels -> Text Messages`.
2. Create a text message with any content.
3. Add/update contacts with a valid email address and a mobile number.
4. Go to `Segments`.
5. Create a new Segment: Add filter having contacts with valid Mobile numbers in it.
6. Go to `Campaigns`.
7. Create a new campaign: Contact Sources: Campaign Segment.
8. Choose the Segment created in step 5.
9. In the next step, select Action.
10. In the Select box, choose Send Text Messages.
11. In the box of Send Text Messages, put a name and choose the message - that you created early.
12. Click the publish button and save your campaign.


### To run the Campaign.

Execute the following commands.

1. `php bin/console cache:clear`
2. `php bin/console mautic:segments:update`
3. `php bin/console mautic:campaigns:update`
4. `php bin/console mautic:campaigns:trigger`


## Note

When using Mautic ActiveMQ Plugin.

1. +XXXXXXXXXXXX format for the contact phone number including the `+` with country code and no space.
2. Fulfilled in the mobile contact field.
3. Dynamic Variables can be added in the Text Messages like `Hi {contactfield=firstname}`
