#!/usr/bin/env python
# coding: utf-8

# In[23]:


import numpy as np
def grad(X,y,l,epochs):
    m = 0
    b = 0
    n = len(X)
    costs = []

    for epoch in range(epochs):
        y_pred = m * X + b
        error = y_pred - y
        m -= l*(1/n)*np.sum(X*error)
        b -= l*(1/n)*np.sum(error)

        if epoch % 100 == 0:
            cost = (1/(2*n)) * np.sum(error**2)
            costs.append(cost)
            print(f'epoch {epoch} : cost {cost} ')
    return m, b

np.random.seed(42)
X = np.random.rand(100)
y = 2 + 3*X + np.random.randn(100)*0.1
l = 0.1
epochs = 1000

m,b = grad(X,y,l,epochs)
print("Slope (m):", m)
print("Intercept (b):", b)


# In[11]:


import numpy as np 
def grad(X,y,l,epochs):
    m = 0
    b = 0
    n = len(X)
    costs = []
    
    for epoch in range(epochs):
        y_pred = m*X + b
        error = y_pred - y
        m -= l*(1/n)*np.sum(X*error)
        b -= l*(1/n)*np.sum(error)
        
        if epoch % 100 == 0:
            cost = (1/(2*n))*np.sum(error**2)
            costs.append(cost)
            print(f'epoch { epoch} , cost: {cost}')
            
    plt.plot(range(0, epochs, 100), costs, marker='o')
    plt.xlabel('Epoch')
    plt.ylabel('Cost')
    plt.title('Epoch vs. Cost')
    plt.show()
            
    return m,b

np.random.seed(42)
m = np.random.rand(100)
b = 2 + 3*X + np.random.randn(100)*0.1
l = 0.1
epochs = 1000

m,b = grad(X,y,l,epochs)
print('Slope:',m)
print('Intercept:',b)


# In[ ]:




