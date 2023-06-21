https://каменная-чаша.рф/

Laravel v10.13.5
----
# Страницы

Список заказов (главная)
Просмотр заказа
Новый заказ
Редактирование заказа

Список клиентов
Просмотр клиента (профайл, список заказов этого клиента)
Новый клиент
Редактирование клиента

Список товаров и услуг
Новый тиу
Редактирование тиу


----
# БД

# product_category
- id
- name

# product
- id
- name
- price
- type (int) 1товар или 2услуга
- product_category_id

# client
- id
- name
- phone
- email
- addr
- comment

# order
- id
- client_id
- status (int) 1принят 2выполняется 3готов

- stella_forma (int) модель1, модель2
- stella_size (string) размер стеллы
- material (int) 1гранит, 2мрамор, 3стекло
- portrait (int) 1по плечи, 2по пояс, 3рост
- portrait_size (string) 30x40, 30x20, 35x25

- fullname (string)
- birth_date (date)
- death_date (date)
- epitafia (string) количество символов

- crescent (int) 1,2,3
- cross (int) 1,2,3
- flower (int)
- icon (int)
- branch (int)
- candle (int)
- angel (int)
- bird (int)
- tombstone (int)

- delivery_km (int)
- delivery_point (text)

- comment (text) комментарий к заказу
- deadline_date (date)

# order_pay
- id
- pay (float)
- order_id (int)
- comment (string)
