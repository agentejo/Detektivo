# Configuration

Create config file detektivo.yaml `config/detektivo.yaml`:

Algolia (https://www.algolia.com):
```
engine: algolia
app_id: YLXXXXXXXYE
api_key: xxxxxx85b706f0daaexxxxxxxx
```

ElasticSearch (https://www.elastic.co):
```
engine: elasticsearch
hosts: [http://localhost:32769]
index: cockpit
```

TNTSearch (https://github.com/teamtnt/tntsearch):
```
engine: tntsearch
```

Collections + fields to index
```
collections:
    posts: [title, excerpt, content]
```


### 💐 SPONSORED BY

[![ginetta](https://user-images.githubusercontent.com/321047/29219315-f1594924-7eb7-11e7-9d58-4dcf3f0ad6d6.png)](https://www.ginetta.net)<br>
We create websites and apps that click with users.
