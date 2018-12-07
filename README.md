Add files to addons/Detektivo.

# Configuration

Configuration `config/config.yaml`:

### Algolia (https://www.algolia.com):
```
detektivo:
    engine: algolia
    app_id: YLXXXXXXXYE
    api_key: xxxxxx85b706f0daaexxxxxxxx
```

### ElasticSearch (https://www.elastic.co):
```
detektivo:
    engine: elasticsearch
    hosts: [http://localhost:32769]
    index: cockpit
```

### TNTSearch (https://github.com/teamtnt/tntsearch):
```
detektivo:
    engine: tntsearch
```

### Collections + fields to index
```
detektivo:
    collections:
        posts: [title, excerpt, content]
```


# Api

Detektivo entry point:

```
/api/detektivo/collection/{name}?token=*apitoken*&q={searchterm}
```


### 💐 SPONSORED BY

[![ginetta](https://user-images.githubusercontent.com/321047/29219315-f1594924-7eb7-11e7-9d58-4dcf3f0ad6d6.png)](https://www.ginetta.net)<br>
We create websites and apps that click with users.
