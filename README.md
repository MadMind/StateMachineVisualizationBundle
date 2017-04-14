State Machine Visualization bundle
==================================

This bundle allows to visually preview your state machine graph.

Installation
------------

### Requirements
dot - Part of graphviz package (http://www.graphviz.org/)

### Installation (via composer)
```sh
composer require madmind/state-machine-visualization-bundle
```

### Register the bundle
```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new MadMind\StateMachineVisualizationBundle\StateMachineVisualizationBundle(),
    );
}
```

### Customize dot location
```yaml
# app/config/config.yml
...
state_machine_visualization:
    dot: /usr/local/bin/dot
    layout: TB # Direction of graph layout. Possible values: LR - from left to right (default), TB - from top to bottom.
    node_shape: circle # Default. Other possible values can be found here: http://www.graphviz.org/doc/info/shapes.html
```

### Configure routing
```yaml
# app/config/routing.yml
...
state_machine_visualization:
    resource: "@StateMachineVisualizationBundle/Resources/config/routing.yml"
    prefix:   /smv
```


#### Usage
See graph of demo state machine (https://github.com/winzou/StateMachineBundle#configure-a-state-machine-graph)

`http://127.0.0.1:8000/smv/my_bundle_article.png`
