https://каменная-чаша.рф/

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
- type (int) товар или услуга
- category_id

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

- stella_forma (int) модель1, модель2
- stella_size (string) размер стеллы
- material (int) 1гранит, 2мрамор, 3стекло
- portrait (int) 1по плечи, 2по пояс, 3рост
- portrait_sizes (string) 30x40, 30x20, 35x25

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

- delivery (int)
- delivery_point (string)

- comment (string) комментарий к заказу

# order_pay
- id
- pay (float)
- order_id (int)
- comment (string)
