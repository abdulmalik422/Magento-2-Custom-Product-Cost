# Magento 2 Custom Product Cost & Extension Attributes Module

A robust Magento 2 extension designed to extend standard product and order functionality by integrating custom product cost tracking into the Admin UI, database schema, REST/SOAP APIs, and Order Item details. 

This project was developed as a custom freelance solution to enable accurate profit margin calculations, ERP integrations, and custom cost exposure via standard Magento APIs.

---

## 🏗️ Architecture & Component Overview

Based on the module directory structure, here is a detailed breakdown of how the key components interact:

```
CustomOptions/
├── Api/
│   └── Data/
│       └── CustomCostOptionInterface.php    # Data Interface for API contracts
├── Model/
│   └── CustomCostOption.php             # Data Model implementing the interface
├── Observer/
│   └── AddProductCostToOrderItem.php    # Captures custom cost during order placement
├── Plugin/
│   └── OrderItemRepositoryPlugin.php    # Extends Order Item API responses with custom cost
├── Ui/
│   └── DataProvider/
│       └── Product/Form/Modifier/       # UI Modifiers to add custom cost field to Product Admin
│           ├── All.php
│           └── Base.php
└── etc/
    ├── adminhtml/di.xml                 # Admin-specific dependency injection
    ├── db_schema.xml                    # Declarative Schema for custom cost columns
    ├── di.xml                           # Dependency injection configuration
    ├── events.xml                       # Event observers mapping (e.g., sales order place)
    ├── extension_attributes.xml         # Exposes custom fields via REST/GraphQL/SOAP APIs
    └── module.xml                       # Module declaration setup
```

---

## ✨ Key Features

1. **Custom Cost Field in Admin Product Form**
   - Implemented dynamic UI Form Modifiers (`Ui/DataProvider/Product/Form/Modifier/`) to seamlessly insert the custom product cost input field into the Magento Admin Product Edit view without modifying core files.

2. **Declarative Database Schema (`db_schema.xml`)**
   - Utilizes Magento 2's Declarative Schema pattern to safely update database tables (e.g., adding `custom_cost` to `sales_order_item` or product catalog tables) supporting clean installations and database rollbacks.

3. **REST / SOAP API Exposure via Extension Attributes**
   - Configured `extension_attributes.xml` and programmatic Plugins (`OrderItemRepositoryPlugin.php`) to append custom cost attributes to the Standard API responses for Orders and Order Items.

4. **Order Placement Data Persistence**
   - Utilizes Event Observers (`AddProductCostToOrderItem.php`) hooked into checkout/order creation events (`events.xml`) to snapshot product cost at the time of purchase, maintaining historical accuracy even if catalog costs change later.

5. **API Data Contracts**
   - Provides strictly-typed interfaces (`CustomCostOptionInterface.php`) and models (`CustomCostOption.php`) following best Magento 2 development practices and SOLID principles.

---

## 🚀 Installation & Setup

### Prerequisites
* Magento 2.4.x
* PHP 8.1 / 8.2

### Step-by-Step Installation

1. **Clone or Copy Module Files**
   Place the module contents into your Magento root under:
   ```bash
   app/code/Vendor/CustomOptions/
   ```

2. **Enable the Module**
   Run the standard Magento CLI commands to register and set up the module:
   ```bash
   bin/magento module:enable Vendor_CustomOptions
   bin/magento setup:upgrade
   bin/magento setup:di:compile
   bin/magento setup:static-content:deploy -f
   bin/magento cache:flush
   ```

---

## 🔧 API Usage Example

With `extension_attributes` configured, fetching an order item via standard REST endpoint:

`GET /rest/V1/orders/:id`

**Response Output:**
```json
{
  "entity_id": 1024,
  "items": [
    {
      "item_id": 405,
      "sku": "CUSTOM-PROD-01",
      "price": 99.00,
      "extension_attributes": {
        "custom_cost": 45.50
      }
    }
  ]
}
```

---

## 🛠️ Tech Stack & Standards

* **Framework:** Magento 2 (2.4+)
* **Architecture:** Declarative Schema, Plugin (Interceptors), Event Observers, Extension Attributes, UI Components.
* **Code Standards:** PSR-12, Magento Coding Standard (MEQP compliant).

---

## 👨‍💻 Developer & Freelance Enquiries

Developed as part of a custom Magento 2 backend integration project. If you are looking for custom Magento 2 extension development, API integrations, or performance optimization, feel free to reach out!