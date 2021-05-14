# Behat Fake Pointer Context Class

Adds Behat steps that allows the user to create step-by-step guides
to using a website that can be recorded by a separate application.

Create test scenarios as you would normally and use the new 
steps in between your usual ones to display and move a fake pointer in the page.
Only one pointer type is currently supported.

## Behat Steps

In the following steps, "identifier" can be xPath, CSS, or text, for example:

```
When I move fake pointer to "User Name"
And I focus fake pointer "#user-name-input"
And I move fake pointer to "//table/tbody/tr[2]/td[5]"
```

### Moving the Pointer
Moves the pointer from it's current position to the centre of the identified element.
```
When I move fake pointer to "identifier"
```

### Clicking an Element
Animates the fake pointer to suggest a click. To perform the click, use an
appropriate step for the element, for example, When I follow "link text".
```
When I click fake pointer
```

### Highlighting an Element
Animates the fake pointer to draw attention to the element or content below it.
```
When I highlight element with fake pointer
```

### Focusing on an Element
Focuses on an element (firing the focus event).
```
When I focus on "identifier"
```

### Scrolling to an Element
Scroll the page toward the element. This is useful when the element sits outside
the viewport and can't be interacted with.
```
When I scroll to "identifier"
```

### Setting the Browser Window Size
Set the width and height of the browser window opened by Behat.
The is good for ensuring consistency for multiple videos / images that need
to be the same size.
```
When I set window size to "1024" wide and "768" high
```

### Prompting the User to Start or Stop Recording
When creating a video it's useful to know when to record.
Use the following to prompt the user to start and stop recording.
The message is displayed in the termainal.
```
When I display start recording message
...
And I display stop recording message
```

## Installation
1. The MinkExtension is required.
2. Clone the repository into your features/bootstrap directory.
3. Clone the [Behat Fake Pointer JavaScript](https://github.com/robtyleratwork/BehatFakePointerJs)
repository into your javascript directory.
4. Clone the [Behat Fake Pointer CSS](https://github.com/robtyleratwork/BehatFakePointerCss)
   repository into your CSS directory.
5. Update your behat.yaml file to reference the new context class:
```
            contexts:
                - Behat\MinkExtension\Context\MinkContext
                - BehatFakePointer\FakePointerContext
```

