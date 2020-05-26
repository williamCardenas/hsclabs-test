# hsclabs-test
Teste para vaga de desenvolvedor na hsclabs

Engineering Redis Challenge

Objective
Redis is an in-memory NoSQL data store that supports operations or “commands” on data structures
such as sets, lists and hashes. Your objective is to implement a service that supports a subset of the
Redis command set. That is, you are to build a “mini redis”.
This has two parts -- first, the implementation of Redis commands and the underlying data structure to
support them, and second (optional part), support for calling this “mini redis” over the network.
As you work on this challenge, try to complete the first part in its entirety before moving on to the
optional part.
Part One: Core
Command Requirements
You are to implement the following set of commands. The command definitions are all available at
http://redis.io/commands.
1. SET key value
2. SET key value EX seconds (need not implement other SET options)
3. GET key
4. DEL key
5. DBSIZE
6. INCR key
7. ZADD key score member
8. ZCARD key
9. ZRANK key member
10. ZRANGE key start stop

Atomicity
One of the key benefits of Redis is that it guarantees atomic, ordered access to data. Your
implementation should offer the same guarantee, so that, for example, access from multiple threads is
handled safely.
Deliverable
When this part of the challenge is complete, you should have a working implementation of the specified
commands, and there should be one or more methods or other entry point that can invoke those
commands.

This should include some sort of test harness or set of test cases that allows the developer to
demonstrate the functionality of the implemented commands.

Part Two (Optional): Networking
In this part of the challenge, you will add a layer handling network connections, enabling access to the
Redis datastore over the network.
Networking Requirements
When launched, your application should listen on port 8080 and serve inbound HTTP connections. You
should not​ be concerned with following the Redis wire protocol; instead, we will make some radical
simplifications:
1. Keys and values can only be the characters from the set [a-zA-Z0-9-_].
2. Commands are ASCII strings with space-delimited parameters.
3. Responses are ASCII strings with space-delimited values (where appropriate).
Other networking requirements:
1. Your server should support multiple​ simultaneous connections, just like real Redis
2. It should be possible to connect to the service via any HTTP client. See example below.
Example
curl localhost:8080/?cmd=SET%20mykey%20cool-value
OK
curl localhost:8080/?cmd=GET%20mykey
cool-value
curl localhost:8080/?cmd=DEL%20mykey
OK
curl localhost:8080/?cmd=GET%20mykey
(nil)
Optionally you could iterate further and use a REST approach for the commands. See below a proposal
for the REST API.

Example
curl -d "cool-value" -X PUT localhost:8080/mykey
OK
curl localhost:8080/mykey
Cool-value
curl -X DELETE localhost:8080/mykey
OK
curl localhost:8080/mykey
(nil)

General Guidance
Languages and Frameworks
You are welcome to use whatever languages and frameworks you are most comfortable with as you
complete this challenge.
Library Support
In order to allow you to focus on implementing the core Redis features effectively, you can use a
performant existing HTTP server library to bootstrap your development of the network layer.
Outside Resources
You are welcome to consult any external, online resources that you find helpful as you work on this
challenge, but be prepared to explain your work and ensure you understand your solution thoroughly.
Submission
When you have completed your implementation, archive it and email it to the Scopely interviewer who
requested you complete the challenge.
