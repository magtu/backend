# 1 Поиск
## 1.1 Поиск по имени группы/преподователя

**GET /api/v2/search?q={query}** <a name="search"></a>

**Ответ**

```javascript
    [
        {
            "id":1,
            "name":"АБб-14-1",
            "url":"АБб-14-1",
            "type":"group"
        },
        {
            "id":7,
            "name":"Абрамова Т.В.",
            "url":"Абрамова_ТВ",
            "type":"teacher"
        }
    ]
```

# 2 Группы
## 2.1 ~~Список всех групп~~ (deprecated используй [search](#search))

**GET /api/v2/groups**

**Ответ**

```javascript
    [
        {
            "id":1,
            "name":"АБб-14-1",
            "url":"АБб-14-1"
        }
    ]
```

## 2.2 ~~Фильтр по имени группы~~ (deprecated используй [search](#search))

**GET /api/v2/groups?q={query}**

**Ответ**

```javascript
[
    {
        "id":1,
        "name":"АБб-14-1",
        "url":"АБб-14-1"
    }
]
```

## 2.3 Расписание группы

**GET /api/v2/groups/{group_id}/schedule**

**Ответ**

```javascript
{
    "id":"2",
    "name":"АБб-14-2",
    "url":"АБб-14-2",
    "type":"group",
    "schedule":[
        {
            "week_id":1,
            "week":"Нечетная",
            "days":[
                {
                    "day_id":1,
                    "day":"Понедельник",
                    "events":[
                        {
                            "event_index":2,
                            "course_id":960,
                            "course":"Управление ИТ-проектами",
                            "type_id":3,
                            "subgroup":0,
                            "location":"1-6202к",
                            "type":"лабораторная",
                            "reverse_id":487,
                            "reverse":"Новикова Т.Б."
                        }
                    ]
                }
            ]
        }
    ]
}
```

## 2.4 Timestamp последнего обновлния расписания группы

**GET /api/v2/groups/{group_id}/updates/schedule**

**Ответ**

```javascript
{
    "updated_at":1455266871
}
```

# 3 Преподователи
## 3.1 ~~Список всех преподователей~~ (deprecated используй [search](#search))

**GET /api/v2/teachers**

**Ответ**

```javascript
    [
        {
            "id":1,
            "name":"АБб-14-1",
            "url":"АБб-14-1"
        }
    ]
```

## 3.2 ~~Фильтр по имени преподователя~~ (deprecated используй [search](#search))

**GET /api/v2/teachers?q={query}**

**Ответ**

```javascript
[
    {
        "id":1,
        "name":"АБб-14-1",
        "url":"АБб-14-1"
    }
]
```

## 3.3 Расписание преподователя

**GET /api/v2/teachers/{teacher_id}/schedule**

**Ответ**

```javascript
{
    "id":"2",
    "name":"Абдулвелеев И.Р.",
    "url":"Абдулвелеев_ИР",
    "type":"teacher",
    "schedule":[
        {
            "week_id":1,
            "week":"Нечетная",
            "days":[
                {
                    "day_id":1,
                    "day":"Понедельник",
                    "events":[]
                },
                {
                    "day_id":2,
                    "day":"Вторник",
                    "events":[
                        {
                            "event_index":1,
                            "course_id":1017,
                            "course":"Математическое моделирование в электроэнергетических системах",
                            "type_id":2,
                            "subgroup":1,
                            "location":"1-142к",
                            "type":"лекция",
                            "reverse_id":41,
                            "reverse":"АЭб-14-2"
                        }
                    ]
                }
            ]
        }
    ]
}
```

## 3.4 Timestamp последнего обновлния расписания преподователя

**GET /api/v2/teachers/{teacher_id}/updates/schedule**

**Ответ**

```javascript
{
    "updated_at":1455266871
}
```