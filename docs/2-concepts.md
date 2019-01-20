Concepts
--------

*The functional point of view*

Whenever you are about to delete a resource, 
you may check whether or not that resource is used elsewhere in your application.

If the resource is not in use, I should be allowed to delete it.
Otherwise, a description of each usage should be displayed to the caller, 
so he can understand why the operation is not permitted.


*The technical point of view*

Before deleting any resource, you have to analyse **relations** of that resource,
and find **usages** between the resource you wish to delete and resources on the other side of each relation.

If you found no usage, you can safely delete the resource.
Otherwise, you should **describe** and print each **usage** to the caller that asked the deletion.


### Definitions

A **relation** is a the **possible** link between two resources.

An **usage** is a the **actual** link between two resources.


### Finding usages

Here we are, your code entered a process to delete a resource.
Before you actually trigger delete operations to your storage system, you must first find usages of that resource.

Here, you will use the [UsageFinder](components/usage-finder.md) to check for resource usages.


### Describing usages

Now, you know that is was unsafe to delete that resource.
Let's tell the caller that asked that operation why we refuse to do what he asked.

Here, you will use the [ObjectDescriptor](components/object-descriptor.md) to give a string representation of each usage.



---

« [Install](1-install.md) • [Usage](3-usage.md) »
