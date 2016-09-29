# 1 Группы
## 1.1 Список всех групп

**GET /api/v1/groups**

**Ответ**

```javascript
    [
        {
            "id":1,
            "name":"АБб-14-1"
        },
        ...
    ]
```

## 1.2 Фильтр по имени группы

**GET /api/v1/groups?q={query}**

**Ответ**

```javascript
[
    {
        "id":1,
        "name":"АБб-14-1"
    },
    ...
]
```

## 1.3 Расписание группы

**GET /api/v1/groups/{group_id}/schedule**

**Ответ**

```javascript
[
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
                        "course_id":479,
                        "course":"Физическая культура",
                        "type_id":1,
                        "type":"пр. зан.",
                        "subgroup":0,
                        "teacher_id":266,
                        "teacher":"Емельянов А.В.",
                        "location":"10-СК-зал"
                    },
                    ...
            },
            ...
        ]
    },
    ...
]
```

## 1.4 Timestamp последнего обновлния расписания группы

**GET /api/v1/groups/{group_id}/updates/schedule**

**Ответ**

```javascript
{
    "updated_at":1455266871
}
```

# 2 Преподователи
## 2.1 Список всех преподователей

**GET /api/v1/groups**

**Ответ**

```javascript
    [
        {
            "id":1,
            "name":"АБб-14-1"
        },
        ...
    ]
```

## 2.2 Фильтр по имени преподователя

**GET /api/v1/teachers?q={query}**

**Ответ**

```javascript
[
    {
        "id":1,
        "name":"Посохов И.А."
    },
    ...
]
```

## 2.3 Расписание преподователя

**GET /api/v1/teachers/{teacher_id}/schedule**

**Ответ**

```javascript
[
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
                        "course_id":479,
                        "course":"Физическая культура",
                        "type_id":1,
                        "type":"пр. зан.",
                        "subgroup":0,
                        "group_id":266,
                        "group":"Емельянов А.В.",
                        "location":"10-СК-зал"
                    },
                    ...
            },
            ...
        ]
    },
    ...
]
```

## 2.4 Timestamp последнего обновлния расписания преподователя

**GET /api/v1/teachers/{teacher_id}/updates/schedule**

**Ответ**

```javascript
{
    "updated_at":1455266871
}
```