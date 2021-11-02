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
Symfony Flex will register the bundle automatically.

For projects without Symfony Flex (usually below version 4.0)
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
# config/packages/state_machine_visualization.yaml
...
state_machine_visualization:
    dot: /usr/local/bin/dot
    layout: TB # Direction of graph layout. Possible values: LR - from left to right (default), TB - from top to bottom.
    node_shape: circle # Default. Other possible values can be found here: http://www.graphviz.org/doc/info/shapes.html
```

### Configure routing
```yaml
# config/routes.yaml
...
state_machine_visualization:
    resource: "@StateMachineVisualizationBundle/Resources/config/routing.yml"
    prefix:   /smv
```

#### Usage
See graph of demo state machine (https://github.com/winzou/StateMachineBundle#configure-a-state-machine-graph)

`http://127.0.0.1:8000/smv/my_bundle_article.png`
