# WHMCS-manual-registrar-module
This module can be used for any TLDs that have no integrated registrar; will create a to do item for any required operation.

To install:
- copy all the files in /your-whmcs/modules/registrars/manual
- in admin area in  WHMCS, go to Setup -> Product/Services / Domain Registrars
- activate "Manual Registrar"

Then you can use it as any other Registrar Module in WHMCS: setup domains to be managed by mean of this module and related prices, change a domain in order to be managed by this module or change it again to be managed by any other registrar module.

In client area user will gain real information about DNS server used by the domain, and will be able to ask to change them (as any other operation, it will not be done automatically, but just a new "to do" item will be created, waiting for you to do it manually).

