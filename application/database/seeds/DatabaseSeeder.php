<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $creatorId = 1; // Default Admin User

        // 1. Clients
        $clientsData = [
            [
                'client_company_name' => 'Acme Corporation',
                'client_phone' => '+1 (555) 234-5678',
                'client_website' => 'https://acme.example.com',
                'client_vat' => 'US987654321',
                'client_billing_street' => '100 Enterprise Way',
                'client_billing_city' => 'New York',
                'client_billing_state' => 'NY',
                'client_billing_zip' => '10001',
                'client_billing_country' => 'United States',
                'client_status' => 'active',
                'client_creatorid' => $creatorId,
                'client_created' => $now,
                'client_updated' => $now,
            ],
            [
                'client_company_name' => 'Nexus Global Tech',
                'client_phone' => '+1 (555) 876-5432',
                'client_website' => 'https://nexusglobal.example.com',
                'client_vat' => 'US123456789',
                'client_billing_street' => '500 Silicon Ave',
                'client_billing_city' => 'San Francisco',
                'client_billing_state' => 'CA',
                'client_billing_zip' => '94107',
                'client_billing_country' => 'United States',
                'client_status' => 'active',
                'client_creatorid' => $creatorId,
                'client_created' => $now,
                'client_updated' => $now,
            ],
            [
                'client_company_name' => 'Stellar Digital Agency',
                'client_phone' => '+44 20 7946 0912',
                'client_website' => 'https://stellardigital.example.com',
                'client_vat' => 'GB999888777',
                'client_billing_street' => '42 Oxford Street',
                'client_billing_city' => 'London',
                'client_billing_state' => 'Greater London',
                'client_billing_zip' => 'W1D 1BS',
                'client_billing_country' => 'United Kingdom',
                'client_status' => 'active',
                'client_creatorid' => $creatorId,
                'client_created' => $now,
                'client_updated' => $now,
            ]
        ];

        $clientIds = [];
        foreach ($clientsData as $client) {
            $existing = DB::table('clients')->where('client_company_name', $client['client_company_name'])->first();
            if ($existing) {
                $clientIds[] = $existing->client_id;
            } else {
                $clientIds[] = DB::table('clients')->insertGetId($client);
            }
        }

        // 2. Client Contacts (Users)
        $contactsData = [
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane@acme.example.com',
                'clientid' => $clientIds[0],
                'type' => 'client',
                'status' => 'active',
                'role_id' => 2,
                'account_owner' => 'yes',
                'creatorid' => $creatorId,
                'created' => $now,
                'updated' => $now,
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Scott',
                'email' => 'michael@nexusglobal.example.com',
                'clientid' => $clientIds[1],
                'type' => 'client',
                'status' => 'active',
                'role_id' => 2,
                'account_owner' => 'yes',
                'creatorid' => $creatorId,
                'created' => $now,
                'updated' => $now,
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Connor',
                'email' => 'sarah@stellardigital.example.com',
                'clientid' => $clientIds[2],
                'type' => 'client',
                'status' => 'active',
                'role_id' => 2,
                'account_owner' => 'yes',
                'creatorid' => $creatorId,
                'created' => $now,
                'updated' => $now,
            ]
        ];

        foreach ($contactsData as $contact) {
            if (!DB::table('users')->where('email', $contact['email'])->exists()) {
                $contact['password'] = Hash::make('password123');
                DB::table('users')->insert($contact);
            }
        }

        // 3. Projects
        $projectsData = [
            [
                'project_title' => 'Enterprise E-Commerce Platform',
                'project_clientid' => $clientIds[0],
                'project_creatorid' => $creatorId,
                'project_status' => 'in_progress',
                'project_progress' => 65,
                'project_billing_type' => 'hourly',
                'project_billing_rate' => 85.00,
                'project_billing_estimated_hours' => 120,
                'project_date_start' => date('Y-m-d', strtotime('-30 days')),
                'project_date_due' => date('Y-m-d', strtotime('+45 days')),
                'project_description' => 'End-to-end e-commerce platform redesign with checkout integration and ERP sync.',
                'project_created' => $now,
                'project_updated' => $now,
            ],
            [
                'project_title' => 'Mobile Banking iOS & Android App',
                'project_clientid' => $clientIds[1],
                'project_creatorid' => $creatorId,
                'project_status' => 'in_progress',
                'project_progress' => 40,
                'project_billing_type' => 'fixed',
                'project_billing_costs_estimate' => 15000.00,
                'project_date_start' => date('Y-m-d', strtotime('-15 days')),
                'project_date_due' => date('Y-m-d', strtotime('+60 days')),
                'project_description' => 'Cross-platform mobile application development with biometric login and real-time transaction alerts.',
                'project_created' => $now,
                'project_updated' => $now,
            ],
            [
                'project_title' => 'Brand Identity & Marketing Website',
                'project_clientid' => $clientIds[2],
                'project_creatorid' => $creatorId,
                'project_status' => 'not_started',
                'project_progress' => 10,
                'project_billing_type' => 'fixed',
                'project_billing_costs_estimate' => 6000.00,
                'project_date_start' => date('Y-m-d'),
                'project_date_due' => date('Y-m-d', strtotime('+30 days')),
                'project_description' => 'Brand strategy, design system, component library, and CMS marketing website.',
                'project_created' => $now,
                'project_updated' => $now,
            ]
        ];

        $projectIds = [];
        foreach ($projectsData as $project) {
            $existing = DB::table('projects')->where('project_title', $project['project_title'])->first();
            if ($existing) {
                $projectIds[] = $existing->project_id;
            } else {
                $pid = DB::table('projects')->insertGetId($project);
                $projectIds[] = $pid;

                // Project assignees & manager
                DB::table('projects_assigned')->insert([
                    'projectsassigned_projectid' => $pid,
                    'projectsassigned_userid' => $creatorId,
                    'projectsassigned_created' => $now,
                    'projectsassigned_updated' => $now,
                ]);
                DB::table('projects_manager')->insert([
                    'projectsmanager_projectid' => $pid,
                    'projectsmanager_userid' => $creatorId,
                    'projectsmanager_created' => $now,
                    'projectsmanager_updated' => $now,
                ]);
            }
        }

        // 4. Milestones
        $milestoneId = DB::table('milestones')->insertGetId([
            'milestone_title' => 'Phase 1: Architecture & UI/UX',
            'milestone_projectid' => $projectIds[0],
            'milestone_creatorid' => $creatorId,
            'milestone_position' => 1,
            'milestone_type' => 'categorised',
            'milestone_created' => $now,
            'milestone_updated' => $now,
        ]);

        // 5. Tasks
        $tasksData = [
            [
                'task_title' => 'Design responsive checkout workflow',
                'task_description' => 'Create wireframes and interactive prototypes for frictionless one-page checkout.',
                'task_projectid' => $projectIds[0],
                'task_clientid' => $clientIds[0],
                'task_milestoneid' => $milestoneId,
                'task_creatorid' => $creatorId,
                'task_position' => 1.0,
                'task_priority' => 'high',
                'task_status' => 3, // In Progress
                'task_date_start' => date('Y-m-d', strtotime('-5 days')),
                'task_date_due' => date('Y-m-d', strtotime('+7 days')),
                'task_created' => $now,
                'task_updated' => $now,
            ],
            [
                'task_title' => 'Configure Stripe & PayPal payment gateways',
                'task_description' => 'Implement webhook endpoints, test card flows, and tokenization.',
                'task_projectid' => $projectIds[0],
                'task_clientid' => $clientIds[0],
                'task_milestoneid' => $milestoneId,
                'task_creatorid' => $creatorId,
                'task_position' => 2.0,
                'task_priority' => 'urgent',
                'task_status' => 1, // New
                'task_date_start' => date('Y-m-d'),
                'task_date_due' => date('Y-m-d', strtotime('+14 days')),
                'task_created' => $now,
                'task_updated' => $now,
            ],
            [
                'task_title' => 'Implement biometric authentication module',
                'task_description' => 'Integrate FaceID / TouchID and Android BiometricPrompt APIs.',
                'task_projectid' => $projectIds[1],
                'task_clientid' => $clientIds[1],
                'task_milestoneid' => 0,
                'task_creatorid' => $creatorId,
                'task_position' => 1.0,
                'task_priority' => 'high',
                'task_status' => 3, // In Progress
                'task_date_start' => date('Y-m-d', strtotime('-10 days')),
                'task_date_due' => date('Y-m-d', strtotime('+10 days')),
                'task_created' => $now,
                'task_updated' => $now,
            ],
            [
                'task_title' => 'Design brand guidelines & typography sheet',
                'task_description' => 'Finalize primary color palette, font pairings, and logo asset kit.',
                'task_projectid' => $projectIds[2],
                'task_clientid' => $clientIds[2],
                'task_milestoneid' => 0,
                'task_creatorid' => $creatorId,
                'task_position' => 1.0,
                'task_priority' => 'normal',
                'task_status' => 2, // Completed
                'task_date_start' => date('Y-m-d', strtotime('-20 days')),
                'task_date_due' => date('Y-m-d', strtotime('-2 days')),
                'task_created' => $now,
                'task_updated' => $now,
            ]
        ];

        foreach ($tasksData as $task) {
            if (!DB::table('tasks')->where('task_title', $task['task_title'])->exists()) {
                $tid = DB::table('tasks')->insertGetId($task);
                DB::table('tasks_assigned')->insert([
                    'tasksassigned_taskid' => $tid,
                    'tasksassigned_userid' => $creatorId,
                    'tasksassigned_created' => $now,
                    'tasksassigned_updated' => $now,
                ]);
            }
        }

        // 6. Leads
        $leadsData = [
            [
                'lead_title' => 'Cloud Infrastructure Migration',
                'lead_firstname' => 'Robert',
                'lead_lastname' => 'Taylor',
                'lead_company_name' => 'Apex Solutions Inc',
                'lead_email' => 'robert@apexsolutions.example.com',
                'lead_phone' => '+1 (555) 432-1098',
                'lead_value' => 14500.00,
                'lead_status' => 1, // New
                'lead_creatorid' => $creatorId,
                'lead_created' => $now,
                'lead_updated' => $now,
            ],
            [
                'lead_title' => 'Custom CRM & ERP Integration',
                'lead_firstname' => 'Emily',
                'lead_lastname' => 'Clark',
                'lead_company_name' => 'Bloom Health Logistics',
                'lead_email' => 'emily@bloomhealth.example.com',
                'lead_phone' => '+1 (555) 987-6543',
                'lead_value' => 22000.00,
                'lead_status' => 5, // Contacted
                'lead_creatorid' => $creatorId,
                'lead_created' => $now,
                'lead_updated' => $now,
            ],
            [
                'lead_title' => 'AI Automated Customer Support Pipeline',
                'lead_firstname' => 'David',
                'lead_lastname' => 'Kim',
                'lead_company_name' => 'Vanguard Financial',
                'lead_email' => 'david@vanguardfin.example.com',
                'lead_phone' => '+1 (555) 678-9012',
                'lead_value' => 35000.00,
                'lead_status' => 3, // Qualified
                'lead_creatorid' => $creatorId,
                'lead_created' => $now,
                'lead_updated' => $now,
            ]
        ];

        foreach ($leadsData as $lead) {
            if (!DB::table('leads')->where('lead_title', $lead['lead_title'])->exists()) {
                DB::table('leads')->insert($lead);
            }
        }

        // 7. Invoices & Line Items
        $invoicesData = [
            [
                'bill_clientid' => $clientIds[0],
                'bill_projectid' => $projectIds[0],
                'bill_creatorid' => $creatorId,
                'bill_date' => date('Y-m-d', strtotime('-10 days')),
                'bill_due_date' => date('Y-m-d', strtotime('+20 days')),
                'bill_subtotal' => 4500.00,
                'bill_amount_before_tax' => 4500.00,
                'bill_final_amount' => 4500.00,
                'bill_status' => 'paid',
                'bill_created' => $now,
                'bill_updated' => $now,
                'items' => [
                    [
                        'lineitem_description' => 'UI/UX Design & Interactive Prototype',
                        'lineitem_rate' => '1500.00',
                        'lineitem_unit' => 'flat',
                        'lineitem_quantity' => 1,
                        'lineitem_total' => 1500.00,
                        'lineitem_position' => 1,
                    ],
                    [
                        'lineitem_description' => 'Frontend Component Development (Sprint 1)',
                        'lineitem_rate' => '75.00',
                        'lineitem_unit' => 'hours',
                        'lineitem_quantity' => 40,
                        'lineitem_total' => 3000.00,
                        'lineitem_position' => 2,
                    ]
                ]
            ],
            [
                'bill_clientid' => $clientIds[1],
                'bill_projectid' => $projectIds[1],
                'bill_creatorid' => $creatorId,
                'bill_date' => date('Y-m-d', strtotime('-3 days')),
                'bill_due_date' => date('Y-m-d', strtotime('+27 days')),
                'bill_subtotal' => 5000.00,
                'bill_amount_before_tax' => 5000.00,
                'bill_final_amount' => 5000.00,
                'bill_status' => 'due',
                'bill_created' => $now,
                'bill_updated' => $now,
                'items' => [
                    [
                        'lineitem_description' => 'Mobile App Milestone 1: Core Architecture & Authentication',
                        'lineitem_rate' => '5000.00',
                        'lineitem_unit' => 'milestone',
                        'lineitem_quantity' => 1,
                        'lineitem_total' => 5000.00,
                        'lineitem_position' => 1,
                    ]
                ]
            ]
        ];

        foreach ($invoicesData as $inv) {
            $items = $inv['items'];
            unset($inv['items']);

            $existing = DB::table('invoices')
                ->where('bill_clientid', $inv['bill_clientid'])
                ->where('bill_projectid', $inv['bill_projectid'])
                ->first();

            if (!$existing) {
                $invId = DB::table('invoices')->insertGetId($inv);
                foreach ($items as $item) {
                    $item['lineitemresource_type'] = 'invoice';
                    $item['lineitemresource_id'] = $invId;
                    $item['lineitem_created'] = $now;
                    $item['lineitem_updated'] = $now;
                    DB::table('lineitems')->insert($item);
                }
            }
        }
    }
}
