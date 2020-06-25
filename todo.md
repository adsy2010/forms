## Things to do

Claim process:

#### New Claim
- Select Claim @
- Choose month for claim @
  - Creates a claim line 
  - Creates scaffold for claim if required (time claim generate entry for every day of month)
  - Open claim with status DRAFT

#### Submit claim
- Open claim
- Finish claim details
- Submit claim
  - Change status to SUBMITTED
  - Send to message to next step on authoriser chain

#### Authorising
- Open Submitted claim
  - Change status to IN PROGRESS
  
  authgroupmembers DB Table
   - authGroup - ad group
   - priority - lowest number is first in the auth chain
   - pattern - all members or 1 member of group
  
### Needed
#### Submissions table
~~need to create a submissions table~~
 - ~~claim id~~
 - ~~chain position~~

relationships:

 - claimID -> FormID
 
 ~~Need a way to link an auth group to a form~~<br>
 Add a relogin feature every day to force new AD sync