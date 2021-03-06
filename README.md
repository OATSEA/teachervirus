# teachervirus

**Repo:** OATSEA/teachervirus

**Version:** 0.5

**Doc Author:** Harry Longworth

**Contributors/Developers:** Vishal Simon, Harry Longworth and OATSEA Team

**Website:** teachervirus.org

##About
**teachervirus** is the core Teacher Virus code that provides the basic functionality of the platform. 

Teacher Virus is the OATSEA Foundation's approach to the Global Learning XPRIZE and is about providing "infectious education" from both a technical and social perspective.

The repository is installed by the **getinfected.php** script that is managed in a separate repository.

That script fetches the core Teacher Virus files from either github or an infected device.  

**NOTE:** Teacher Virus is only viral from a philosophical perspective - it can not infect a device without the consent of the administrator/owner of the device (installation action required).

At the heart of teachervirus is the installation and management of "payloads" which are our version of components/plugins/apps that serve an educational purpose.

##Assumptions
To keep things simple we make the following assumptions at this point:
* the webserver will be installed prior to installation (or on Android will be using the Teacher Virus Android App which is based on DroidPHP).
* getinfected.php will be in the root folder of the webserver (included in the Android Teacher Virus app).
* Teacher Virus will be installed in the root of the webserver (although efforts have been made to allow subfolder installs).
* The system will not be used on production devices or on a "public" network (additional security required such as the use of a .htaccess).
* student's will have dedicated devices (i.e thus don't need to "Sign in")

##What's New? 
With version 0.5 of Teacher Virus we introduce the following improvements:
* Major restructure of the folders to support sync based distribution.
* Online catalog based installation of payloads
* Fix various bugs

##Wishlist / Future Development
We are always looking for suggestions and feedback on each release so that we can prioritise functionality required for the next sprint.  At the moment we are looking at working on the following capabilities for the next phase of development:

* ability to manage payloads.
* ability to find out about new versions and update payloads.
* ability to view a catalog of payloads available on a infected device and install them with a click.
* ability to discover infected devices on the local network.
* ability to install content separately from payloads.
* ability to transfer "data" payloads between devices (e.g. student results).
* multi-lingual interface
* help content/interface (in English and Swahili)
* resolve Android version 5 issues.
* Mobile responsive interface = test on wide range of device types and screen sizes.

##Longer Term Development / Roadmap:
* user identification based on device identification (rather than student login).
* global params/settings/configuration.
* device specific settings / configuration.
* student analytics and tracking.
* Fuel for fun, progress points and "skills tree" in order to allow identification of appropriate material based on student progress and control access.
* "playlists" to chain together payloads and selected content.
* "teacherbot" for adaptive presentation of curriculum and access control to payloads (e.g. Fuel for fun to dictate playtime usage).
* development of specific payloads to meet functional requirements and provide desired capabilities
* provide "shared services" as identified by payload creators

##Known Issues:
* There known deployment issues with Android version 5 that we may not be able to resolve due to vendor and provider security constraints
* Further investigation required into security aspects of use on public webservers (use .htaccess to increase security of admin area?)



