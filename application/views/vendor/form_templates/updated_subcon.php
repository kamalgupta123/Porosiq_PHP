<!DOCTYPE html>
<html lang="en">
<head>
    <title>Updated COMPANY SUBCONTRACTOR AGREEMENT</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        img {
            text-align: center;
            width: 45%;
        }

        span {
            display: block;
        }

        .form-control {
            background-color: #fff;
            box-shadow: none;
            border-radius: 0px;
            background-image: none;
            border-color: currentcolor currentcolor #000;
            border-image: none;
            border-style: none none solid;
            border-width: medium medium 1px;
            color: #555;
            display: block;
            font-size: 14px;
            height: 34px;
            line-height: 1.42857;
            padding: 6px 12px;
            width: 100%;
        }

        .form-control1 {
            background-color: #fff;
            box-shadow: none;
            border-radius: 0px;
            background-image: none;
            border-color: currentcolor currentcolor #000;
            border-image: none;
            border-style: none none solid;
            border-width: medium medium 1px;
            color: #555;
            display: inline-block;
            font-size: 14px;
            height: 34px;
            line-height: 1.42857;
            padding: 6px 12px;
            width: 15%;
        }

        .image {
            text-align: center;
        }

        .image h4 {
            margin: 65px 0 0;
        }

        .area {
            background-color: #fff;
            background-image: none;
            color: #555;
            display: block;
            font-size: 14px;
            height: 34px;
            line-height: 1.42857;
            padding: 6px 12px;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
            width: 100%;
        }

        td {
            border: 1px solid #000;
            width: 50%;
        }

        .text {
            border: medium none;
            outline: medium none;
            padding: 10px;
            width: 100%;
        }

        .subcon {
            margin: 30px 0;
        }

        .container {
            width: 800px;
        }

        .space {
            margin: 30px 0;
        }

        .form-control:focus {
            box-shadow: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="image">
        <img src="<?php echo base_url(); ?>assets/images/pts.jpg" alt="">

        <h2>COMPANY SUBCONTRACTOR AGREEMENT</h2>
    </div>
    <form id="subcontractor_form"
          action="<?php echo site_url('add_subcontractor_form'); ?>"
          method="post" enctype="multipart/form-data">
        <div class="subcon">
            <p>This SUBCONTRACTOR AGREEMENT made this<input class="form-control1 validate[required]" id="con_day" name="con_day"
                                                            type="text">day of<input
                    class="form-control1 validate[required]" id="con_month" name="con_month" type="text">,20<input class="form-control1 validate[required]"
                                                                                                id="con_year"
                                                                                                name="con_year"
                                                                                                type="text"> between PNC
                CAPITAL LLC dba
                PROCURETECHSTAFF CONSULTING SERVICES, with offices located at 155 N Michigan Ave, Suite 513, Chicago IL
                60601 hereinafter referred to as the “Company,” and<input class="form-control1 validate[required]" id="con_comp" name="con_comp"
                                                                          type="text"> 
                herein after referred to as the “Consulting Firm,” where applicable, with offices  located at<input
                    class="form-control1 validate[required]" id="con_location" name="con_location" type="text">. The Consulting Firm’s Tax
                Identification Number
                is<input class="form-control1 validate[required]" id="con_tin_no" name="con_tin_no" type="text">.<br><br>
                RECITALS<br><br>
                WHEREAS, the Company is in the business of providing professional consulting services, including
                computer
                programming services, to customers desiring such service (each such customer, a “Client”) pursuant to
                contracts between the Company and each Client (each such contract a “Client Agreement”).<br><br>
                WHEREAS, in connection with these services, Company from time to time is required to retain third party
                consultants to assist with such services. <br><br>
                WHEREAS, Consulting Firm is in the business of providing computer programming services and personnel
                (“Consultants”) on a project basis.
            </p>
            <!--<div class="image">
                 <span>155 N Michigan Ave, Suite 513  Chicago, IL 60601 </span>
               <span>Tel: 773-304-3630</span>
               <span>Fax: 773-747-4056</span>
               <span><a href="#">  www.procuretechstaff.com</a></span>
             </div>-->
        </div>
        <div class="subcon">
            <h5>NOW, THEREFORE, in consideration of the mutual promises and covenants contained herein, the parties
                hereto
                hereby agree as follows:</h5>

            <p>1.<strong> Scope of Work</strong> <br> At the Company’s request and subject to acceptance by the Client,
                the
                Consulting Firm will provide services and Consultants to the Company’s Clients. The services to be
                rendered
                by the Consulting Firm shall be set forth in a task order in the form of Schedule B hereto (the “Task
                Order”) which shall be attached hereto and made a part of this Agreement. Each Task Order shall set
                forth
                the specific Client and project, as well as the services and the Consulting Firm’s fees, and may be
                supplemented, modified or revised as may be required to provide the services to the Client, with the
                consent
                of the Company and the Consulting Firm. </p>

            <p>2.<strong> Contract Price and Invoicing</strong><br> (a) The Company shall pay the Consulting Firm a fee
                as
                set forth in each Task Order. Consulting Firm shall provide invoices for payment as set forth in
                paragraph
                (b) hereof. Payments on such invoices shall be made by the Company to the Consulting  Firm on a Net 45
                basis. However, the Company reserves the right to offset against future payments owed to the Consulting
                Firm, or recover from the Consulting Firm, any portion of a paid invoice for which the Client refuses to
                pay
                the Company. <br>
                (b) The Consulting Firm shall submit monthly invoices on its own letterhead or  form for services
                performed
                by its Consultants; provided, however, that in the event the Client, as part of the Client Agreement for
                the
                Client’s policies and procedures,  requires invoices or time compilations to be maintained in a
                specified
                format, the Consulting Firm shall cause its Consultants to comply with such format and requirements.The
                Consulting Firm agrees that in the event it fails to render invoices within 120 days from the end of the
                month in which such services are rendered, it waives any and all claims against the Company for payment,
                regardless of whether the Company is paid by the Client for such services.<br>
                (c) The Consulting Firm shall be responsible for its Consultants’ travel and business expenses;
                provided,
                however, that if, pursuant to the Client Agreement, the Company is entitled to reimbursement for travel
                and
                business expenses from the Client for the Consulting Firm’s travel and business expense, the Company
                shall
                reimburse the Consulting Firm, to the extent and in the manner the Company is reimbursed by the Client.
                <br>
                (d) It is understood and agreed that if the Client deems the Consulting Firm’s work product unacceptable
                and
                refuses to pay the Company for the Consulting Firm’s work or seeks reimbursement from the Company for
                the
                value of such work if already paid for by the Client, the Company is relieved from any obligation to pay
                the
                Consulting Firm for same. The Company may withhold the disputed amount from any monies that may be due
                to
                the Consulting Firm from any source. If the Consulting Firm has been paid for same, it shall immediately
                repay such funds to the Company.
            </p>

            <p>3. <strong>Independent Contractor Status</strong><br> (a) The Consulting Firm represents that neither it
                nor
                its Consultants are employees of the Company or the Client and are not entitled to any fringe benefits
                or
                employment rights from the Company or the Client. The Consulting Firm will be solely liable for any of
                its
                Consultant’s fringe benefits, including but not limited to vacation, sick leave, holidays,
                health/liability
                insurance and for paying any payroll-related taxes or contributions required by law.<br>
                By way of example and not by way of limitation, the Consulting firm will be solely liable for any: (i)
                Federal, State or Local taxes based on or measured by the Consulting Firm’s income or receipts; (ii)
                Federal
                Insurance Contributions Act (“FICA”) taxes with regard to any Consultant, if any; (iii) Federal
                Unemployment
                Tax Act (“FUTA”) contributions with regard to any Consultant; and (iv) State Unemployment Insurance
                (“SUI”)
                contributions, if any, and all other applicable payroll tax obligations with regard to any
                Consultant.<br>The
                Consulting Firm will withhold all applicable Federal, State and Local income taxes and the employee’s
                share
                of FICA or other applicable payroll taxes borne by the employee. The Company will have no obligation to
                withhold Federal, State or Local income tax, or employee’s portion of FICA or other payroll taxes from
                any
                payment to the Consulting Firm, nor will the Company have any liability for any FICA, FUTA or SUI
                contributions or other payroll taxes on behalf of the Consulting Firm or its Consultants.<br>The
                Consulting
                Firm will timely file, and cause its Consultants to file, all applicable tax returns, including income
                tax
                returns, employment tax returns, and information returns required by law, in a manner consistent with
                its
                status as an independent contractor and as an employer of individual personnel assigned hereunder.<br>
                (b) At the Company’s request, the Consulting Firm will provide the Company with a copy of IRS Form 941
                and
                other appropriate governmental forms, showing that the Consulting Firm has properly made appropriate
                payments and filed appropriate returns for all taxes, social security, worker’s compensation,
                unemployment
                and disability benefits. Submission of such forms shall be a condition precedent for payment of services
                by
                the Company to the Consulting Firm.<br>
                (c) Neither the Consulting Firm nor any Consultant has the right or ability to bind the Company or the
                Client to any obligation with a third party without the Company’s or Client’s express written
                permission.
                <br>(d) The Consulting Firm reserves the right to provide services through other brokers or directly to
                end
                users other than the Client, simultaneously with this Agreement (providing such services are not in
                conflict
                with paragraph 8 hereinafter).
            </p>

            <p>
                4. <strong>Liability; Indemnification</strong><br> (a) The Consulting Firm shall indemnify, protect,
                defend
                and hold the Company and the Client, and their respective officers, employees, agents, parents,
                subsidiaries, and affiliated companies, harmless from and against any and all claims, liabilities,
                losses,
                damages, injuries, demands, actions, causes of action, suits, proceedings, judgments, and expenses,
                including, without limitation, reasonable attorney fees, court costs, and other reasonable legal
                expenses
                (collectively, “Indemnified Claims”),which are based on or arise from: (i) any actions or omissions of
                the
                Consulting Firm, its agents or employees in performance under this Agreement, (ii) any breach by the
                Consulting Firm of its representations, warranties, covenants, agreements or obligations contained in
                this
                Agreement, and (iii) any alleged or actual infringement of any work product or services provided by the
                Consulting Firm or its Consultants of any patent, copyright or other property right of a third party;
                provided, however,  that the Company or the Client shall not be entitled to indemnification hereunder in
                a 
                case where the Indemnified Claim is solely based on or arises from the intentional fault of the Company.<br>(b)
                The Consulting Firm’s liability under this Agreement shall not exceed the total payment received by the
                Consulting Firm from the Company for performance under this Agreement, provided, however that this
                limitation shall not apply to the Consulting Firm’s obligation to indemnify if any such Indemnified
                Claim
                arises from or is based upon: (i) personal injury or damage to tangible property caused by the actions
                or
                omissions of the Consulting Firm, its agents, employees or Consultants in performance of this Agreement;
                (ii) any alleged infringement of any copyright, trademark, trade secret, patent or other intellectual
                property; or (iii) the Consulting Firm’s breach of its obligations under Sections 3, 7(e), 8, 9 and 10
                of
                this Agreement, concerning the Consulting Firm’s status as an independent contractor, confidential
                information, non-solicitation and noncompetition.<br>(c) Except as expressly provided in this Agreement,
                neither the Company nor the Consulting Firm shall be liable to the other for any indirect, incidental,
                special or consequential damages (including lost profits) in connection with this Agreement, however
                caused,
                whether based on contract, tort, warranty or other legal theory, and whether or not informed of the
                possibility of such damages.
            </p>

            <p>
                5. <strong>Insurance  The Consulting Firm agrees to maintain insurance in accordance with the
                    following:</strong> • Workers Compensation & Employer’s Liability as required under the law of the
                state
                in which the work is performed.<br> • Commercial General Liability covering all operations of the
                Consulting
                Firm, including product and completed operations and contractual liability against claims for personal
                bodily injury and property damage with a liability limit not less than $1,000,000 per occurrence/annual
                aggregate.<br> • Automobile Liability Insurance covering bodily injury and property damage liability
                arising
                out of the use by or on behalf of the Consulting Firm, its agents or employees of any owned, non-owned
                or
                hired automobile with a combined limit of not less than $1,000,000.<br> • Errors & Omission Insurance
                covering loss or damage arising out of negligent acts or errors or omissions which arise from service
                provided by the Consulting Firm under this Agreement with a limit of not less than $1,000,000 per
                occurrence. Such insurance coverage as is required under this Agreement shall be in a form reasonably
                satisfactory to the Company and the Client, with insurance carriers reasonably satisfactory to the
                Company
                and the Client and licensed to do business in the state where the services are provided, unless
                otherwise
                provided herein, and shall name the Company and the Client as additional insured parties thereunder. As
                evidence of said coverage, the Consulting Firm shall deliver to the Company prior to the execution of
                this
                Agreement, Certificates of Insurance, or copies of insurance policies, which shall contain a provision
                requiring that the Company and the Client be notified in writing of a cancellation or nonrenewal of said
                coverages not less than thirty (30) days before its effective date. The Consulting Firm shall not cancel
                or
                modify such insurance policies during the term of this Agreement without giving thirty (30) day prior
                written notice to the Company and the Client and obtaining Company and Client written consent. The
                foregoing
                statements as to the types and limits of insurance coverage to be maintained by the Consulting Firm is
                not
                intended to and shall not in any manner limit or qualify the liabilities and obligations otherwise
                assumed
                by the Consulting Firm pursuant to this Agreement, including but not limited to the provisions
                concerning
                indemnification.
            </p>

            <p>
                6.<strong> Consulting Firm’ s Representation</strong><br> (a) The Consulting Firm represents and
                warrants
                that its Consultants have the expertise to provide the services necessary for completion of the projects
                referenced on each Task Order without supervision and in accordance with the standards of good
                professional
                practice. The Company shall not be responsible for determining the manner and means in which each
                Consultant
                carries out the tasks hereunder.<br>(b) The Consulting Firm further represents and warrants that it and
                its
                Consultants are under no restriction, contractually or otherwise, to any present or former broker,
                Client,
                employer, associate, partnership or corporation, business entity or person, which would prevent or
                restrict
                them in any manner whatsoever, from performing under this Agreement.<br> (c) The Consulting Firm will
                comply, and cause its Consultants to comply, with Client policies that are applicable to the services
                being
                performed by the Consultants, and copies of each Client policy will be provided or made available to the
                Consulting Firm. The Consulting Firm agrees to prevent its Consultants from loading onto Client’s
                computers
                or computer system any software other than at the Client’s express request or as approved in writing by
                the
                Client prior to the Consultant loading such software. The Consulting Firm agrees to cause its
                Consultants to
                follow all the Client’s written or otherwise documented standards, policies and where applicable,
                methodologies, related to the Client’s computer systems (e.g., security, environmental, disaster
                recovery,
                virus detection and removal). <br>(d) The Consulting Firm represents and warrants that (i) it and all
                its
                personnel shall abide by Federal, State and Local laws, regulations and ordinances with respect to the
                services provided hereunder, (ii) the employment or retention of such personnel to render such services
                provided for hereunder shall comply with all such Federal, State and Local laws, regulations and
                ordinances
                and the Consulting Firm will be responsible for any fees, permits, payments and taxes that may be
                required
                for the Consulting Firm’s performance of its obligations under this Agreement, (iii) all Consultants
                will be
                citizens of the United States or possess the legal right to work in the United States in accordance with
                the
                Immigration Reform and Control Act of 1986 and the Immigration Act of 1990, both as amended from time to
                time; in furtherance of the forgoing,and not by way of limitation, the Consulting Firm specifically
                represents that any of its personnel providing services for the Company hereunder and required to have a
                valid visa in place to work in the United States and render such services (a “Visa Employee”) in fact
                has
                such a visa, that the Consulting Firm has confirmed that such a visa is currently in place and
                effective,
                and that the Consulting Firm’s employment records for any such individual contain a copy of such visa
                and
                any back-up documentation related to such visa, and (iv) Consulting Firm is an equal opportunity
                employer as
                described in Section 202 of Executive Order 11246, dated September 24, 1976, as amended, and as such
                will
                comply with all applicable requirements during the performance of this Agreement including applicable
                requirements relating to (1) the provisions of said Executive Order and its implementing regulations,
                (2)
                the affirmative action requirements of Part 60-741.4 of Title 41, Code of Federal Regulations, with
                respect
                to handicapped workers during the performance of this Agreement, (3) the affirmative action requirements
                of
                Part 60250.5 of Title 41, Code of Federal Regulations with respect to Disabled Veterans and Veterans of
                the
                Vietnam Era during the performance of this Agreement, and (4) the requirements of Parts 52-219.12 of
                Title
                48, Code of Federal Regulations, with respect to the utilization of minority and female-owned business
                enterprises, as each of these are amended from time to time. Consulting Firm warrants that it shall
                monitor
                the expiration dates of Consultants’ visas and work permits, if any. The Consulting Firm shall be solely
                responsible for ensuring compliance with all laws and regulations relating thereto. <br>(e) From time to
                time, upon the reasonable request of the Company, the Consulting Firm shall submit written status
                reports
                describing its activities hereunder and the Services performed during the preceding or specified period,
                including the current status of activities and the Services performed hereunder, resources used since
                the
                last report, identifications of any problems and actions taken to resolve them. In addition, as
                requested by
                the Company, the Consulting Firm agrees to provide all documentation required by the Client for vendor
                audits.<br>(f) All Consulting Firm employees to furnish services hereunder shall be subject to prior
                approval by the Company and/or Client. <br> (g) Consulting Firm shall use its best efforts to minimize
                any
                disruption to Client’s normal business operations and ensure the continuity of its employees' services
                assigned to work for the Client (including by ensuring that vacation time for its employees assigned to
                Client hereunder shall be scheduled so as not to interfere with Client’s deadlines or performance or
                completion of services hereunder). <br> (h) The Consulting Firm represents and warrants each Visa
                Employee
                is a direct employee of the Consulting Firm, not an independent contractor of the Consulting Firm or an
                individual whose services have been contracted for by the Consulting Firm through another entity, and
                that
                the Consulting Firm is the sponsor of the Visa Employee’s visa. As requested by the Company, the
                Consulting
                Firm agrees to provide to the Company documentation to support the status of each Visa Employee
                including
                verification of salary. <br>(i) Any request for verification of employment, project assignment status or
                other
                documentation required for immigration filings shall be made in writing by the Consulting Firm to the
                Company only. The Consulting Firm and its employees agree not to directly contact the Client regarding
                such
                documents.
            </p>

            <p>
                7.<strong> Terms, Termination and Cancellation</strong><br> (a) The term of this Agreement shall begin
                as of
                the date first written and shall remain in force until terminated pursuant to the terms hereof. <br>(b)
                The
                Company may terminate this Agreement and/or any outstanding Task Order hereunder: (i) upon five (5) days
                written notice to Consulting Firm; (ii) immediately in the event that the Consulting Firm breaches any
                provision of this Agreement; (iii) immediately in the event that the Client terminates the Client
                Agreement
                or (iv) immediately in the event that the Consulting Firm becomes or is declared insolvent or bankrupt,
                is
                the subject of any proceeding related to its liquidation or insolvency, or for the appointment of a
                receiver, conservator or similar officer, is unable to pay its debts as they become due, makes an
                assignment
                to or for the benefit of its creditors, or ceases to conduct business for any reason on an ongoing basis
                leaving no successor or interest. <br> (c) The Consulting Firm may terminate this Agreement (i) upon ten
                (10) days prior written notice to the Company or (ii) in the event the Company materially breaches this
                Agreement and fails to cure such breach within thirty (30) days after receiving written notice of same,
                specifying the circumstances of such alleged breach.<br> (d) Upon termination of this Agreement or any
                Task
                Order for any reason, the Consulting Firm shall promptly deliver to the Company all papers, documents,
                software programs and other tangible items (including all copies) constituting confidential  information
                (as
                defined under Section 10 hereof) in possession of the Consulting  Firm or its Consultants. <br>(e) So
                long
                as this Agreement shall remain in effect and for a period of one year subsequent, each party does hereby
                agree not to offer employment to or employ, directly or indirectly (as employees, contractors,
                consultants,
                etc.) any employee, consultant, sub-contractor or other agent of the other party. The Consulting Firm
                further agrees that it will not hire or offer to hire any employee or other agent of the Client for such
                one-year period. <br>(f) Section 7(e) shall not apply to or restrict either party's right to solicit or
                recruit generally in the media consistent with past practice, and shall not prohibit either party from
                hiring an employee, consultant or agent of the other party who answers any advertisement or who
                otherwise
                voluntarily applies for hire without first having been personally solicited or recruited by such party.
            </p>

            <p>
                8.
                <strong.Restrictive Covenant
                </strong><br> (a) The Consulting Firm agrees during the term of this Agreement or any extension thereof,
                and
                for a period of one year thereafter, neither it nor any of its Consultants will directly, or indirectly,
                or
                in any capacity, compete or attempt to compete with the Company, any parent, subsidiary or affiliate of
                the
                Company, or any corporation merged into or merged or consolidated with the Company, in the provision of
                computer programming or data processing services by soliciting the Client or by soliciting any project
                work
                at the Client or by employing any such personnel for the purpose of engaging in such activities. The
                provisions of this paragraph shall be construed as an Agreement independent of any other provision
                contained
                herein and shall be enforceable in both law and equity, including by temporary or permanent restraining
                orders, notwithstanding the existence of any claim or cause of action by the Consulting Firm or any of
                its
                Consultants against the Company, whether predicated on this Agreement or otherwise. The Consulting Firm
                shall cause its Consultants to acknowledge and agree to be bound by this provision.<br> (b) In the event
                that the scope or enforceability of this paragraph is found by a judge or an arbitrator to be too broad,
                it
                may be modified and enforced to the extent deemed reasonable under the circumstance existing at that
                time.<br>(c) This paragraph shall survive termination of the Agreement. The Consulting Firm agrees to
                sign
                any consents, licenses or other documents reasonably necessary to accomplish such assignment, and to
                cause
                its Consultants to execute such documentation as may be necessary to effectuate such assignment.
            </p>
            <p>
                9.<strong> Ownership </strong><br> (a) Except as otherwise noted, the Client will own all technical
                notes,
                programs, specifications, documentation and other information, tangible and intangible property, and
                work
                products prepared in connection with performance of this Agreement, or required to be delivered and/or
                purchased and/or created under this Agreement. The Consulting Firm hereby releases, and shall cause each
                of
                its Consultants to the extent necessary, to release to the Client any right, title and interest that it
                might have to any work product, tangible or intangible, produced for the Client during the term of this
                Agreement. At project completion the Consulting Firm will promptly deliver or cause its Consultants to
                deliver to the Client all tangible properties and work products produced, purchased, created or which
                contributed to the tasks performed hereunder.<br> (b) Title to all material and documentation, including
                but
                not limited to system specifications, furnished by the Client, shall remain the property of the Client
                and
                whenever such material is delivered by the Client into the possession of the Consulting Firm or its
                Consultants it shall return the same, or cause its Consultants to return the same to the Client
                forthwith at
                the Client’s request or upon termination of this Agreement.<br> (c) This Section 9 shall survive
                termination
                of the Agreement. The Consulting Firm agrees to sign any consents, licenses or other documents
                reasonably
                necessary to accomplish such assignment, and to cause its Consultants to execute such documentation as
                may
                be necessary to effectuate such assignment.<br>
            </p>

            <p>
                10. <strong>Confidential Information</strong><br> (a) The Consulting Firm agrees that the following
                constitutes confidential information (“Confidential Information”) or trade secrets and agrees not to
                disclose such Confidential Information, directly or indirectly through its Consultants, employees or
                other
                agents to anyone during the term of this Agreement or thereafter: (i) non- public information acquired
                during the performance of this contract, whether regarding the Company or the Client; (ii) the finances,
                business affairs and circumstances of the Client or the Company; and (iii) all information and data
                relating
                to the project hereunder and its operation. <br> (b) The Consulting Firm shall cause each of its
                Consultants
                to sign a confidentiality agreement reflecting the terms of this Section 10. Such confidentiality
                agreement
                shall either be on a form provided to the Consulting Firm by the Company, or on a form specified by the
                Client <br>
                (c) This section shall survive termination of the Agreement. The Consulting Firm agrees to sign any
                consents, licenses or other documents reasonably necessary to accomplish such assignment, and to cause
                its
                Consultants to execute such documentation as may be necessary to effectuate such assignment.
            </p>

            <p>
                11. <strong>Remedies</strong><br> (a) The Consulting Firm acknowledges that compliance with paragraphs
                7(e),
                8, 9 and  10 are necessary to protect the business and good will of the Company and that a breach of
                those
                sections will irreparably and continually damage the Company for which money damages may not be
                adequate.<br> (b) Consequently, the Consulting Firm agrees that in the event of a breach or threatened
                breach of these covenants by the Consulting Firm or its Consultants, the Company shall be entitled to
                both:
                (i) a preliminary or permanent injunction in order to prevent the continuation of such harm and (ii)
                money
                damages in so far as they can be determined. Nothing in this Agreement, however, shall be construed to
                prohibit the Company from also pursing any other remedy, the parties having agreed that all remedies
                shall
                be cumulative.
            </p>

            <p><strong>12. Waiver or Breach</strong> <br>If either party breaches or fails to comply with any terms of
                this
                Agreement, and the other party elects to waive same, such waiver shall not be construed as a waiver of
                future breaches or failures to comply.</p>

            <p><strong> 13. Entire Agreement</strong> <br> This document contains the entire Agreement of the parties’
                relation to the subject matter hereof. No waiver, change or modification of any of the terms hereof or
                extension or discharge of this Agreement shall be binding on the Company unless in writing, signed by an
                authorized person of the Company.</p>

            <p>14. <strong>Law of Illinois; Arbitration</strong><br> This Agreement shall be deemed to be a contract
                made
                under the laws of the State of Illinois and for all purposes shall be governed by, construed,
                interpreted
                and enforced according to the laws of the State of Illinois. Any dispute between the parties, whether
                during
                the Term of this Agreement or afterwards, shall be settled by binding arbitration in accordance with the
                Commercial Arbitration Rules of the American Arbitration Association then in effect before three
                arbitrators. The Company shall select one arbitrator. The Consulting Firm shall select one arbitrator,
                and
                the two arbitrators shall select a third arbitrator.</p>

            <p>15.<strong> Severability</strong><br> If any of the provisions of this Agreement shall be invalid,
                illegal or
                unenforceable, such invalidity, illegality or unenforceability shall not render the entire Agreement
                invalid
                and shall be construed as if not containing the particular invalid, illegal or unenforceable
                provision(s),
                and the rights and obligations of each party shall be construed and enforced accordingly. </p>

            <p> 16. <strong>Assignment</strong><br> The Company may assign this Agreement to an entity that acquires all
                or
                substantially all of Company’s assets, or acquires fifty percent (50%) or more of the Company’s issued
                and
                outstanding stock, or is acquired by the Company, or merges with the Company. The Consulting Firm may
                not
                assign this Agreement or its rights or obligations under this Agreement without the prior written
                consent of
                the Company and, to the extent required under the Client Agreement, the Client.</p>

            <h3>IN WITNESS WHEREOF, the parties hereto have executed this Agreement as of the date first above
                written.</h3>

            <h3> WITNESSTH: PNC CAPITAL LLC DBA PROCURETECHSTAFF CONSULTING SERVICES</h3>

            <div class="row space">
                <div class="col-sm-6">
                    <label class="control-label" for="email"> Name: </label>
                </div>
                <div class="col-sm-6"><input type="text" class="form-control validate[required]" id="admin_name" name="admin_name"></div>
            </div>
            <div class="row space">
                <div class="col-sm-6">
                    <label class="control-label" for="email"> Designation: </label>
                </div>
                <div class="col-sm-6"><input type="text" class="form-control validate[required]" id="admin_designation"
                                             name="admin_designation"></div>
            </div>
            <div class="row space">
                <div class="col-sm-6">
                    <label class="control-label" for="email"> Signature: </label>
                </div>
                <div class="col-sm-6"><input type="text" class="form-control validate[required]" id="admin_signature" name="admin_signature" style="font-family: 'Dancing Script', cursive; font-size: 1.7em;">
                </div>
            </div>
            <div class="row space">
                <div class="col-sm-6">
                    <label class="control-label" for="email"> WITNESSTH: </label>
                </div>
                <div class="col-sm-6"><input type="text" class="form-control validate[required]" id="emp_witnessth" name="emp_witnessth">
                </div>
            </div>
            <div class="row space">
                <div class="col-sm-6">
                    <label class="control-label" for="email"> Name: </label>
                </div>
                <div class="col-sm-6"><input type="text" class="form-control validate[required]" id="emp_name" name="emp_name"></div>
            </div>
            <div class="row space">
                <div class="col-sm-6">
                    <label class="control-label" for="email"> Designation: </label>
                </div>
                <div class="col-sm-6"><input type="text" class="form-control validate[required]" id="emp_designation"
                                             name="emp_designation"></div>
            </div>
            <div class="row space">
                <div class="col-sm-6">
                    <label class="control-label" for="email"> Signature: </label>
                </div>
                <div class="col-sm-6"><input type="text" class="form-control validate[required]" id="emp_signature" name="emp_signature" style="font-family: 'Dancing Script', cursive; font-size: 1.7em;">
                </div>
            </div>
        </div>
        <div class="image">
            <span>155 N Michigan Ave, Suite 513  Chicago, IL 60601 </span>
            <span>Tel: 773-304-3630</span>
            <span>Fax: 773-747-4056</span>
            <span><a href="#"> www.procuretechstaff.com</a></span>
        </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <input class="btn btn-success" type="submit" name="submit" value="Submit Form">
                <a class="btn btn-warning" href="<?php echo site_url('all_documents_lists'); ?>" style="text-decoration: none;">Back</a>
                <input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>">
                <input type="hidden" name="vendor_ip" value="<?php echo $vendor_ip; ?>">
                <input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
            </div>
    </form>
</div>
<link rel="stylesheet"
      href="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/css/validationEngine.jquery.css"
      type="text/css"/>
<script src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/languages/jquery.validationEngine-en.js"
        type="text/javascript" charset="utf-8">
</script>
<script src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/jquery.validationEngine.js"
        type="text/javascript" charset="utf-8">
</script>
<script>
    $(document).ready(function () {
        // binds form submission and fields to the validation engine
        $("#subcontractor_form").validationEngine({promptPosition: 'inline'});
    });

</script>

</body>
</html>
